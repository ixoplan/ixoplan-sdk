<?php

namespace Ixolit\Dislo\Context;


use Ixolit\Dislo\Client;
use Ixolit\Dislo\Exceptions\InvalidTokenException;
use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\WorkingObjects\AuthToken;
use Ixolit\Dislo\WorkingObjects\BillingEvent;
use Ixolit\Dislo\WorkingObjects\CachedObject;
use Ixolit\Dislo\WorkingObjects\Flexible;
use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserContext
 *
 * @package Ixolit\Dislo\Context
 *
 * @deprecated use Ixolit\Dislo\Context\User instead
 */
class UserContext {

    /** @var Client */
    private $client;

    /** @var UserContextWrapper */
    private $user;

    /** @var CachedObject|null */
    private $subscriptionsCachedObject;

    /** @var CachedObject|null */
    private $activeFlexibleCachedObject;

    /** @var BillingEvent[] */
    private $billingEvents;

    /** @var int */
    private $billingEventsTotalCount;

    /** @var CachedObject|null */
    private $accountBalanceCachedObject;

    /** @var CachedObject|null*/
    private $authTokensCachedObject;

    /**
     * @param Client             $client
     * @param UserContextWrapper $user
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
     * @return UserContextWrapper
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
        if ($cached && isset($this->subscriptionsCachedObject)) {
            return $this->subscriptionsCachedObject->getObject();
        }

        $this->subscriptionsCachedObject = new CachedObject(
            $this->getClient()->subscriptionGetAll($this->getUserIdentifierForClient())->getSubscriptions()
        );

        return $this->subscriptionsCachedObject->getObject();
    }

    /**
     * @return $this
     */
    public function removeSubscriptionsCache() {
        $this->subscriptionsCachedObject = null;

        return $this;
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
     * @return Subscription|null
     */
    public function getFirstActiveSubscription($cached = true) {
        $activeSubscriptions = $this->getActiveSubscriptions($cached);

        if (empty($activeSubscriptions)) {
            return null;
        }

        return \reset($activeSubscriptions);
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
     * @return Subscription|null
     */
    public function getSubscription($subscriptionId, $cached = true) {
        $subscriptions = $this->getAllSubscriptions($cached);

        foreach ($subscriptions as $subscription) {
            if ($subscription->getSubscriptionId() == $subscriptionId) {
                return $subscription;
            }
        }

        return null;
    }

    /**
     * @param Subscription $subscription
     *
     * @return $this
     */
    public function addSubscription(Subscription $subscription) {
        $subscriptions = $this->getAllSubscriptions(true);

        $subscriptions[] = $subscription;

        $this->subscriptionsCachedObject = new CachedObject($subscriptions);

        return $this;
    }

    /**
     * @param bool $cached
     *
     * @return Flexible
     *
     * @throws ObjectNotFoundException
     */
    public function getActiveFlexible($cached = true) {
        if (!$cached || !isset($this->activeFlexibleCachedObject)) {
            try {
                $this->activeFlexibleCachedObject = new CachedObject(
                    $this->getClient()->billingGetFlexible($this->getUserIdentifierForClient())->getFlexible()
                );
            } catch (ObjectNotFoundException $e) {
                $this->activeFlexibleCachedObject = new CachedObject(null);
            }
        }

        if (empty($this->activeFlexibleCachedObject->getObject())) {
            throw new ObjectNotFoundException(
                'No active flexible for user #' . $this->getUser()->getUserId() . ' found.'
            );
        }

        return $this->activeFlexibleCachedObject->getObject();
    }

    /**
     * @return $this
     */
    public function removeActiveFlexibleCache() {
        $this->activeFlexibleCachedObject = null;

        return $this;
    }

    /**
     * @param Flexible $activeFlexible
     *
     * @return $this
     */
    public function setActiveFlexible(Flexible $activeFlexible) {
        $this->activeFlexibleCachedObject = new CachedObject($activeFlexible);

        return $this;
    }

    /**
     * @param int    $limit
     * @param int    $offset
     * @param string $orderDir
     * @param bool   $cached
     *
     * @return BillingEvent[]
     *
     * @deprecated
     */
    public function getBillingEvents($limit = 10,
                                     $offset = 0,
                                     $orderDir = Client::ORDER_DIR_DESC,
                                     $cached = true
    ) {
        if ($cached && isset($this->billingEvents)) {
            return $this->billingEvents;
        }

        $billingEventsResponse = $this->getClient()->billingGetEventsForUser(
            $this->getUserIdentifierForClient(),
            $limit,
            $offset,
            $orderDir
        );

        $this->billingEvents = $billingEventsResponse->getBillingEvents();
        $this->billingEventsTotalCount = $billingEventsResponse->getTotalCount();

        return $this->billingEvents;
    }

    /**
     * @param int  $billingEventId
     * @param bool $cached
     *
     * @return BillingEvent|null
     *
     * @deprecated
     */
    public function getBillingEvent($billingEventId, $cached = true) {
        $billingEvents = $this->getBillingEvents(10, 0, Client::ORDER_DIR_DESC, $cached);

        foreach ($billingEvents as $billingEvent) {
            if ($billingEvent->getBillingEventId() == $billingEventId) {
                return $billingEvent;
            }
        }

        return null;
    }

    /**
     * @param BillingEvent $billingEvent
     *
     * @return $this
     *
     * @deprecated
     */
    public function addBillingEvent(BillingEvent $billingEvent) {
        $this->getBillingEvents();

        $this->billingEvents[] = $billingEvent;

        return $this;
    }

    /**
     * @param int    $limit
     * @param int    $offset
     * @param string $orderDir
     * @param bool   $cached
     *
     * @return int
     *
     * @deprecated
     */
    public function getBillingEventsTotalCount($limit = 10,
                                               $offset = 0,
                                               $orderDir = Client::ORDER_DIR_DESC,
                                               $cached = true
    ) {
        if ($cached && isset($this->billingEventsTotalCount)) {
            return $this->billingEventsTotalCount;
        }

        $this->getBillingEvents($limit, $offset, $orderDir, $cached);

        return $this->billingEventsTotalCount;
    }

    /**
     * @param bool $cached
     *
     * @return Price
     */
    public function getAccountBalance($cached = true) {
        if ($cached && isset($this->accountBalanceCachedObject)) {
            return $this->accountBalanceCachedObject->getObject();
        }

        $this->accountBalanceCachedObject = new CachedObject(
            $this->getClient()->userGetBalance($this->getUserIdentifierForClient())->getBalance()
        );

        return $this->accountBalanceCachedObject->getObject();
    }

    /**
     * @param bool $cached
     *
     * @return AuthToken[]
     */
    public function getAuthTokens($cached = true) {
        if ($cached && isset($this->authTokensCachedObject)) {
            return $this->authTokensCachedObject->getObject();
        }

        $this->authTokensCachedObject = new CachedObject(
            $this->getClient()->userGetTokens($this->getUserIdentifierForClient())->getTokens()
        );

        return $this->authTokensCachedObject->getObject();
    }

    /**
     * @return $this
     */
    public function removeAuthTokensCache() {
        $this->authTokensCachedObject = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function saveUserMetaData() {
        return $this->changeUserMetaData($this->getUser()->getMetaData());
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

        $this->activeFlexibleCachedObject = new CachedObject(null);

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
     * @param UserContextWrapper $user
     * @param AuthToken          $authToken
     *
     * @return UserContextWrapper
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