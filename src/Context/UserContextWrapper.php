<?php

namespace Ixolit\Dislo\Context;


use Ixolit\Dislo\Exceptions\InvalidTokenException;
use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\FrontendClient;
use Ixolit\Dislo\WorkingObjects\Billing\FlexibleObject;
use Ixolit\Dislo\WorkingObjects\CachedObject;
use Ixolit\Dislo\WorkingObjects\Subscription\PriceObject;
use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;
use Ixolit\Dislo\WorkingObjects\User\AuthTokenObject;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class UserContextWrapper
 *
 * @package Ixolit\Dislo\Context
 */
final class UserContextWrapper {

    /**
     * @var FrontendClient
     */
    private $frontendClient;

    /**
     * @var UserObject
     */
    private $user;

    /**
     * @var CachedObject|null
     */
    private $subscriptionsCachedObject;

    /**
     * @var CachedObject|null
     */
    private $activeFlexibleCachedObject;

    /**
     * @var CachedObject|null
     */
    private $accountBalanceCachedObject;

    /**
     * @var CachedObject|null
     */
    private $authTokensCachedObject;

    /**
     * User constructor.
     *
     * @param FrontendClient $frontendClient
     * @param UserObject     $user
     *
     * @throws InvalidTokenException
     */
    public function __construct(FrontendClient $frontendClient, UserObject $user) {
        $this->frontendClient = $frontendClient;
        $this->user = $user;

        if ($this->frontendClient->isForceTokenMode() && !$user->getAuthToken()) {
            throw new InvalidTokenException();
        }
    }

    /**
     * @return FrontendClient
     */
    private function getFrontendClient() {
        return $this->frontendClient;
    }



    /**
     * @return UserObject
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
     * @return SubscriptionObject[]
     */
    public function getAllSubscriptions($cached = true) {
        if (!($cached && isset($this->subscriptionsCachedObject))) {
            $this->subscriptionsCachedObject = new CachedObject(
                $this->getFrontendClient()->subscriptionGetAll($this->getUserIdentifierForClient())->getSubscriptions()
            );
        }

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
     * @return SubscriptionObject[]
     */
    public function getActiveSubscriptions($cached = true) {
        $subscriptions = $this->getAllSubscriptions($cached);

        $activeSubscriptions = [];
        foreach ($subscriptions as $subscription) {
            if (
            \in_array($subscription->getStatus(), [
                SubscriptionObject::STATUS_CANCELED,
                SubscriptionObject::STATUS_RUNNING
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
     * @return SubscriptionObject|null
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
     * @return SubscriptionObject[]
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
     * @return SubscriptionObject|null
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
     * @return SubscriptionObject|null
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
     * @param SubscriptionObject $subscription
     *
     * @return $this
     */
    public function addSubscription(SubscriptionObject $subscription) {
        $subscriptions = $this->getAllSubscriptions(true);

        $subscriptions[] = $subscription;

        $this->subscriptionsCachedObject = new CachedObject($subscriptions);

        return $this;
    }

    /**
     * @param bool $cached
     *
     * @return FlexibleObject
     *
     * @throws ObjectNotFoundException
     */
    public function getActiveFlexible($cached = true) {
        if (!$cached || !isset($this->activeFlexibleCachedObject)) {
            try {
                $this->activeFlexibleCachedObject = new CachedObject(
                    $this->getFrontendClient()->billingGetFlexible($this->getUserIdentifierForClient())->getFlexible()
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
     * @param FlexibleObject $activeFlexible
     *
     * @return $this
     */
    public function setActiveFlexible(FlexibleObject $activeFlexible) {
        $this->activeFlexibleCachedObject = new CachedObject($activeFlexible);

        return $this;
    }

    /**
     * @param bool $cached
     *
     * @return PriceObject
     */
    public function getAccountBalance($cached = true) {
        if (!($cached && isset($this->accountBalanceCachedObject))) {
            $this->accountBalanceCachedObject = new CachedObject(
                $this->getFrontendClient()->userGetAccountBalance($this->getUserIdentifierForClient())->getBalance()
            );
        }

        return $this->accountBalanceCachedObject->getObject();
    }

    /**
     * @return $this
     */
    public function removeAccountBalanceCache() {
        $this->accountBalanceCachedObject = null;

        return $this;
    }

    /**
     * @param bool $cached
     *
     * @return AuthTokenObject[]
     */
    public function getAuthTokens($cached = true) {
        if (!($cached && isset($this->authTokensCachedObject))) {
            $this->authTokensCachedObject = new CachedObject(
                $this->getFrontendClient()->userGetTokens($this->getUserIdentifierForClient())->getTokens()
            );
        }

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
     * @param array $userMetaData
     *
     * @return $this
     */
    public function changeUserMetaData($userMetaData = []) {
        $changedUser = $this->getFrontendClient()->userChange(
            $this->getUserIdentifierForClient(),
            $this->getUser()->getLanguage(),
            $userMetaData
        )->getUser();

        $this->user = $this->convertFromUserWithAuthToken($changedUser);

        return $this;
    }

    /**
     * @param string $newPassword
     *
     * @return $this
     */
    public function changeUserPassword($newPassword) {

        $changedUser = $this->getFrontendClient()->userChangePassword(
            $this->getUserIdentifierForClient(),
            $newPassword
        )->getUser();

        $this->user = $this->convertFromUserWithAuthToken($changedUser);

        return $this;
    }

    /**
     * @return $this
     */
    public function deleteUser() {
        $this->getFrontendClient()->userDelete($this->getUserIdentifierForClient());

        $this->user = null;

        return $this;
    }

    /**
     * @return $this
     */
    public function disableUserLogin() {
        $changedUser = $this->getFrontendClient()->userDisableLogin($this->getUserIdentifierForClient())->getUser();

        $this->user = $this->convertFromUserWithAuthToken($changedUser);

        return $this;
    }

    /**
     * @return $this
     */
    public function enableUserLogin() {
        $changedUser = $this->getFrontendClient()->userEnableLogin($this->getUserIdentifierForClient())->getUser();

        $this->user = $this->convertFromUserWithAuthToken($changedUser);

        return $this;
    }

    /**
     * @return $this
     */
    public function closeActiveFlexible() {
        $this->getFrontendClient()->billingCloseFlexible(
            $this->getActiveFlexible(),
            $this->getUserIdentifierForClient()
        );

        $this->activeFlexibleCachedObject = new CachedObject(null);

        return $this;
    }

    /**
     * @param UserObject      $user
     *
     * @return UserObject
     */
    protected function convertFromUserWithAuthToken(UserObject $user) {
        $changedUser = new UserObject(
            $user->getUserId(),
            $user->getCreatedAt(),
            $user->isLoginDisabled(),
            $user->getLanguage(),
            $user->getLastLoginDate(),
            $user->getLastLoginIp(),
            $user->getMetaData(),
            $user->getCurrencyCode(),
            $user->getVerifiedData(),
            $this->getUser()->getAuthToken()
        );

        return $changedUser;
    }

    /**
     * @return int|string
     *
     * @throws InvalidTokenException
     */
    protected function getUserIdentifierForClient() {
        if ($this->getFrontendClient()->isForceTokenMode()) {
            if (!$this->getUser()->getAuthToken()) {
                throw new InvalidTokenException();
            }

            return $this->getUser()->getAuthToken()->getToken();
        }

        return $this->getUser()->getUserId();
    }

}