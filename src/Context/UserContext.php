<?php

namespace Ixolit\Dislo\Context;


use Ixolit\Dislo\Client;
use Ixolit\Dislo\Exceptions\InvalidTokenException;
use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\WorkingObjects\AuthToken;
use Ixolit\Dislo\WorkingObjects\BillingEvent;
use Ixolit\Dislo\WorkingObjects\Flexible;
use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserContext
 *
 * @package Ixolit\Dislo\Context
 */
class UserContext {

    /** @var Client */
    private $client;

    /** @var User */
    private $user;

    /** @var Subscription[] */
    private $subscriptions;

    /** @var Flexible */
    private $activeFlexible;

    /** @var BillingEvent[] */
    private $billingEvents;

    /** @var Price */
    private $accountBalance;

    /** @var AuthToken[] */
    private $authTokens;

    /**
     * @param Client $client
     * @param User   $user
     *
     * @throws InvalidTokenException
     */
    public function __construct(Client $client, User $user) {
        $this->client = $client;
        $this->user = $user;

        if ($this->client->isForceTokenMode() && !$user->getAuthToken()) {
            throw new InvalidTokenException();
        }
    }

    /**
     * @return User
     *
     * @throws InvalidTokenException
     */
    public function getUser() {
        if (!isset($this->user)) {
            throw new InvalidTokenException();
        }

        return $this->user;
    }

    /**
     * @param bool $cached
     *
     * @return Subscription[]
     */
    public function getAllSubscriptions($cached = true) {
        if ($cached && isset($this->subscriptions)) {
            return $this->subscriptions;
        }

        $this->subscriptions = $this->getClient()->subscriptionGetAll(
            $this->getUserIdentifierForClient()
        )->getSubscriptions();

        return $this->subscriptions;
    }

    /**
     * @param bool $cached
     *
     * @return Subscription[]
     */
    public function getActiveSubscriptions($cached = true) {
        $subscriptions = $this->getAllSubscriptions($cached);

        $activeSubscriptions = [];
        foreach ($subscriptions as $subscription) {
            if (
                \in_array($subscription->getStatus(), [
                    Subscription::STATUS_CANCELED,
                    Subscription::STATUS_RUNNING
                ])
            ) {
                $activeSubscriptions[] = $subscription;
            }
        }

        return $activeSubscriptions;
    }

    /**
     * @param bool $cached
     *
     * @return Subscription[]
     */
    public function getStartedSubscriptions($cached = true) {
        $subscriptions = $this->getAllSubscriptions($cached);

        $startedSubscriptions = [];
        foreach ($subscriptions as $subscription) {
            if ($subscription->getStartedAt()) {
                $startedSubscriptions[] = $subscription;
            }
        }

        return $startedSubscriptions;
    }

    /**
     * @param bool $cached
     *
     * @return Subscription|null
     */
    public function getFirstStartedSubscription($cached = true) {
        $startedSubscriptions = $this->getStartedSubscriptions($cached);

        if (empty($startedSubscriptions)) {
            return null;
        }

        return \reset($startedSubscriptions);
    }

    /**
     * @param      $subscriptionId
     * @param bool $cached
     *
     * @return Subscription
     *
     * @throws ObjectNotFoundException
     */
    public function getSubscription($subscriptionId, $cached = true) {
        $subscriptions = $this->getAllSubscriptions($cached);

        foreach ($subscriptions as $subscription) {
            if ($subscription->getSubscriptionId() == $subscriptionId) {
                return $subscription;
            }
        }

        throw new ObjectNotFoundException('Subscription #' . $subscriptionId . ' not found.');
    }

    /**
     * @param bool $cached
     *
     * @return Flexible
     */
    public function getActiveFlexible($cached = true) {
        if ($cached && isset($this->activeFlexible)) {
            return $this->activeFlexible;
        }

        $this->activeFlexible = $this->getClient()->billingGetFlexible(
            $this->getUserIdentifierForClient()
        )->getFlexible();

        return $this->activeFlexible;
    }

    /**
     * @param bool $cached
     *
     * @return BillingEvent[]
     */
    public function getBillingEvents($cached = true) {
        if ($cached && isset($this->billingEvents)) {
            return $this->billingEvents;
        }

        $this->billingEvents = $this->getClient()->billingGetEventsForUser(
            $this->getUserIdentifierForClient()
        )->getBillingEvents();

        return $this->billingEvents;
    }

    /**
     * @param bool $cached
     *
     * @return Price
     */
    public function getAccountBalance($cached = true) {
        if ($cached && isset($this->accountBalance)) {
            return $this->accountBalance;
        }

        $this->accountBalance = $this->getClient()->userGetBalance($this->getUserIdentifierForClient())->getBalance();

        return $this->accountBalance;
    }

    /**
     * @param bool $cached
     *
     * @return AuthToken[]
     */
    public function getAuthTokens($cached = true) {
        if ($cached && isset($this->authTokens)) {
            return $this->authTokens;
        }

        $this->authTokens = $this->getClient()->userGetTokens($this->getUserIdentifierForClient())->getTokens();

        return $this->authTokens;
    }

    /**
     * @param array $userMetaData
     *
     * @return $this
     */
    public function changeUserMetaData($userMetaData = []) {
        $authToken = $this->getUser()->getAuthToken();

        $changedUser = $this->getClient()->userChange(
            $this->getUserIdentifierForClient(),
            $this->getUser()->getLanguage(),
            $userMetaData
        )->getUser();

        $this->user = $this->convertFromUserWithAuthToken($changedUser, $authToken);

        return $this;
    }

    /**
     * @param string $newPassword
     *
     * @return $this
     */
    public function changeUserPassword($newPassword) {
        $authToken = $this->getUser()->getAuthToken();

        $changedUser = $this->getClient()->userChangePassword(
            $this->getUserIdentifierForClient(),
            $newPassword
        )->getUser();

        $this->user = $this->convertFromUserWithAuthToken($changedUser, $authToken);

        return $this;
    }

    /**
     * @return $this
     */
    public function deleteUser() {
        $this->getClient()->userDelete($this->getUserIdentifierForClient());

        $this->user = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function disableUserLogin() {
        $this->user = $this->getClient()->userDisableLogin($this->getUserIdentifierForClient())->getUser();

        return $this;
    }

    /**
     * @return $this
     */
    public function closeActiveFlexible() {
        $this->getClient()->billingCloseFlexible($this->getActiveFlexible(), $this->getUserIdentifierForClient());

        $this->activeFlexible = null;

        return $this;
    }

    /*
     * Protected helper functions
     */

    /**
     * @return Client
     */
    protected function getClient() {
        return $this->client;
    }

    /**
     * @param User      $user
     * @param AuthToken $authToken
     *
     * @return User
     */
    protected function convertFromUserWithAuthToken(User $user, AuthToken $authToken) {
        $changedUser = new User(
            $user->getUserId(),
            $user->getCreatedAt(),
            $user->isLoginDisabled(),
            $user->getLanguage(),
            $user->getLastLoginDate(),
            $user->getLastLoginIp(),
            $user->getMetaData(),
            $user->getCurrencyCode(),
            $user->getVerifiedData(),
            $authToken
        );

        return $changedUser;
    }

    /**
     * @return int|string
     *
     * @throws InvalidTokenException
     */
    protected function getUserIdentifierForClient() {
        if ($this->getClient()->isForceTokenMode()) {
            if (!$this->getUser()->getAuthToken()) {
                throw new InvalidTokenException();
            }

            return $this->getUser()->getAuthToken()->getToken();
        }

        return $this->getUser()->getUserId();
    }

}