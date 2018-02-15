<?php

use Ixolit\Dislo\Context\UserContextWrapper;
use Ixolit\Dislo\Exceptions\InvalidTokenException;
use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\FrontendClient;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\Response\TestBillingCloseFlexibleResponse;
use Ixolit\Dislo\Test\Response\TestBillingGetFlexibleResponse;
use Ixolit\Dislo\Test\Response\TestResponseInterface;
use Ixolit\Dislo\Test\Response\TestSubscriptionGetAllResponse;
use Ixolit\Dislo\Test\Response\TestUserChangePasswordResponse;
use Ixolit\Dislo\Test\Response\TestUserChangeResponse;
use Ixolit\Dislo\Test\Response\TestUserDeleteResponse;
use Ixolit\Dislo\Test\Response\TestUserDisableLoginResponse;
use Ixolit\Dislo\Test\Response\TestUserEnableLoginResponse;
use Ixolit\Dislo\Test\Response\TestUserGetAccountBalanceResponse;
use Ixolit\Dislo\Test\Response\TestUserGetTokensResponse;
use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class UserContextWrapperTest
 */
class UserContextWrapperTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testUserContextWrapperInstantion() {
        //test with correct user and forceTokenMode
        $testUser = UserMock::create(true);

        $frontendClient = $this->createFrontendClient();

        try {
            $this->createUserContextWrapper($frontendClient, $testUser);

            $this->assertTrue(true);
        } catch (InvalidTokenException $e) {
            $this->assertTrue(false);
        }

        //test invalid user
        $testUser = UserMock::create(false);

        try {
            $this->createUserContextWrapper($frontendClient, $testUser);

            $this->assertTrue(false);
        } catch (InvalidTokenException $e) {
            $this->assertTrue(true);
        }

        //test user context wrapper without force token mode

        $frontendClient = $this->createFrontendClient([], false);

        try {
            $this->createUserContextWrapper($frontendClient, $testUser);

            $this->assertTrue(true);
        } catch (InvalidTokenException $e) {
            $this->assertTrue(false);
        }
    }

    /**
     * @return void
     */
    public function testGetUser() {
        $testUser = UserMock::create(true);

        $userContextWrapper = $this->createUserContextWrapper([], $testUser);

        $user = $userContextWrapper->getUser();

        $this->compareUser($user, $testUser);
    }

    /**
     * @return void
     */
    public function testGetAllSubscriptions() {
        $testResponse = new TestSubscriptionGetAllResponse();
        $testSubscriptions = $testResponse->getSubscriptions();

        $frontendClient = $this->createFrontendClient($testResponse);

        $userContextWrapper = $this->createUserContextWrapper($frontendClient);

        //test with cached
        $subscriptions = $userContextWrapper->getAllSubscriptions();

        $this->assertEquals(\count($subscriptions), \count($testSubscriptions));

        foreach ($subscriptions as $subscription) {
            if (!isset($testSubscriptions[$subscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($subscription, $testSubscriptions[$subscription->getSubscriptionId()]);
        }

        $otherTestResponse = new TestSubscriptionGetAllResponse();
        $otherTestSubscriptions = $otherTestResponse->getSubscriptions();

        $frontendClient->setRequestClient($this->createTestRequestClient($otherTestResponse));

        $subscriptions = $userContextWrapper->getAllSubscriptions();

        $this->assertEquals(\count($subscriptions), \count($testSubscriptions));

        foreach ($subscriptions as $subscription) {
            if (!isset($testSubscriptions[$subscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($subscription, $testSubscriptions[$subscription->getSubscriptionId()]);
        }

        foreach ($subscriptions as $subscription) {
            $this->assertTrue(!isset($otherTestSubscriptions[$subscription->getSubscriptionId()]));
        }

        //test without cache
        $subscriptions = $userContextWrapper->getAllSubscriptions(false);

        foreach ($subscriptions as $subscription) {
            $this->assertTrue(!isset($testSubscriptions[$subscription->getSubscriptionId()]));
        }

        $this->assertEquals(\count($subscriptions), \count($otherTestSubscriptions));

        foreach ($subscriptions as $subscription) {
            if (!isset($otherTestSubscriptions[$subscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($subscription, $otherTestSubscriptions[$subscription->getSubscriptionId()]);
        }
    }

    /**
     * @return void
     */
    public function testRemoveSubscriptionCache() {
        $testResponse = new TestSubscriptionGetAllResponse();
        $testSubscriptions = $testResponse->getSubscriptions();

        $frontendClient = $this->createFrontendClient($testResponse);

        $userContextWrapper = $this->createUserContextWrapper($frontendClient);

        //test with cached
        $userContextWrapper->getAllSubscriptions();

        $frontendClient->setRequestClient($this->createTestRequestClient(new TestSubscriptionGetAllResponse()));

        $subscriptions = $userContextWrapper
            ->removeSubscriptionsCache()
            ->getAllSubscriptions();

        foreach ($subscriptions as $subscription) {
            $this->assertTrue(!isset($testSubscriptions[$subscription->getSubscriptionId()]));
        }
    }

    /**
     * @return void
     */
    public function testGetActiveSubscriptions() {
        $testResponse = new TestSubscriptionGetAllResponse();

        $userContextWrapper = $this->createUserContextWrapper($testResponse);

        $testSubscriptions = $testResponse->getActiveSubscriptions();

        $subscriptions = $userContextWrapper->getActiveSubscriptions();

        $this->assertEquals(\count($subscriptions), \count($testSubscriptions));

        foreach ($subscriptions as $subscription) {
            if (!isset($testSubscriptions[$subscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($subscription, $testSubscriptions[$subscription->getSubscriptionId()]);
        }
    }

    /**
     * @return void
     */
    public function testGetFirstActiveSubscription() {
        $testResponse = new TestSubscriptionGetAllResponse(SubscriptionObject::STATUS_RUNNING);
        $testSubscriptions = $testResponse->getActiveSubscriptions();

        $activeSubscription = $this->createUserContextWrapper($testResponse)->getFirstActiveSubscription();

        $this->compareSubscription($activeSubscription, \reset($testSubscriptions));
    }

    /**
     * @return void
     */
    public function testGetStartedSubscriptions() {
        $testResponse = new TestSubscriptionGetAllResponse();

        $testSubscriptions = $testResponse->getStartedSubscriptions();

        $subscriptions = $this->createUserContextWrapper($testResponse)->getStartedSubscriptions();

        $this->assertEquals(\count($subscriptions), \count($testSubscriptions));

        foreach ($subscriptions as $subscription) {
            if (!isset($testSubscriptions[$subscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($subscription, $testSubscriptions[$subscription->getSubscriptionId()]);
        }
    }

    /**
     * @return void
     */
    public function testGetFirstStartedSubscription() {
        $testResponse = new TestSubscriptionGetAllResponse();
        $testSubscriptions = $testResponse->getStartedSubscriptions();

        $subscription = $this->createUserContextWrapper($testResponse)->getFirstStartedSubscription();

        $this->compareSubscription($subscription, \reset($testSubscriptions));
    }

    /**
     * @return void
     */
    public function testGetSubscription() {
        $testResponse = new TestSubscriptionGetAllResponse();
        $testSubscriptions = $testResponse->getSubscriptions();
        $testSubscription = \reset($testSubscriptions);

        $subscription = $this->createUserContextWrapper($testResponse)->getSubscription($testSubscription->getSubscriptionId());

        $this->compareSubscription($subscription, $testSubscription);
    }

    /**
     * @return void
     */
    public function testAddSubscription() {
        $testResponse = new TestSubscriptionGetAllResponse();
        $testSubscriptions = $testResponse->getSubscriptions();

        $newSubscription = SubscriptionMock::create();

        $userContextWrapper = $this->createUserContextWrapper($testResponse);

        $userContextWrapper->addSubscription($newSubscription);

        $subscriptions = $userContextWrapper->getAllSubscriptions();

        $testSubscriptions[$newSubscription->getSubscriptionId()] = $newSubscription;

        $this->assertEquals(\count($subscriptions), \count($testSubscriptions));

        foreach ($subscriptions as $subscription) {
            if (!isset($testSubscriptions[$subscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($subscription, $testSubscriptions[$subscription->getSubscriptionId()]);
        }

        $subscriptionAdded = false;
        foreach ($subscriptions as $subscription) {
            if ($subscription->getSubscriptionId() === $newSubscription->getSubscriptionId()) {
                $subscriptionAdded = true;

                break;
            }
        }

        $this->assertTrue($subscriptionAdded);
    }

    public function testGetActiveFlexible() {
        $testResponse = new TestBillingGetFlexibleResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $userContextWrapper = $this->createUserContextWrapper($frontendClient);

        try {
            $flexible = $userContextWrapper->getActiveFlexible();

            $this->compareFlexible($flexible, $testResponse->getFlexible());
        } catch (ObjectNotFoundException $e) {
            $this->assertTrue(false);
        }

        //test cache
        $newTestResponse = new TestBillingGetFlexibleResponse();

        $frontendClient->setRequestClient($this->createTestRequestClient($newTestResponse));

        try {
            $flexible = $userContextWrapper->getActiveFlexible();

            $this->assertEquals($flexible->getFlexibleId(), $testResponse->getFlexible()->getFlexibleId());
            $this->assertNotEquals($flexible->getFlexibleId(), $newTestResponse->getFlexible()->getFlexibleId());
        } catch (ObjectNotFoundException $e) {
            $this->assertTrue(false);
        }

        //test without cache
        try {
            $flexible = $userContextWrapper->getActiveFlexible(false);

            $this->assertEquals($flexible->getFlexibleId(), $newTestResponse->getFlexible()->getFlexibleId());
            $this->assertNotEquals($flexible->getFlexibleId(), $testResponse->getFlexible()->getFlexibleId());
        } catch (ObjectNotFoundException $e) {
            $this->assertTrue(false);
        }

        //test without active flexible
        $testResponse = new TestBillingGetFlexibleResponse(true);

        $frontendClient->setRequestClient($this->createTestRequestClient($testResponse));

        try {
            $userContextWrapper->getActiveFlexible(false);

            $this->assertTrue(false);
        } catch (ObjectNotFoundException $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @return void
     */
    public function testRemoveActiveFlexibleCache() {
        $testResponse = new TestBillingGetFlexibleResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $userContextWrapper = $this->createUserContextWrapper($frontendClient);

        //test with cached
        $userContextWrapper->getActiveFlexible();

        $frontendClient->setRequestClient($this->createTestRequestClient(new TestBillingGetFlexibleResponse()));

        $flexible = $userContextWrapper
            ->removeActiveFlexibleCache()
            ->getActiveFlexible();

        $this->assertNotEquals($flexible->getFlexibleId(), $testResponse->getFlexible()->getFlexibleId());
    }

    /**
     * @return void
     */
    public function testSetActiveFlexible() {
        $testFlexible = FlexibleMock::create();

        $userContextWrapper = $this->createUserContextWrapper(new TestBillingGetFlexibleResponse());

        $flexible = $userContextWrapper
            ->setActiveFlexible($testFlexible)
            ->getActiveFlexible();

        $this->compareFlexible($flexible, $testFlexible);
    }

    /**
     * @return void
     */
    public function testGetAccountBalance() {
        $testResponse = new TestUserGetAccountBalanceResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $userContextWrapper = $this->createUserContextWrapper($frontendClient);

        $accountBalance = $userContextWrapper->getAccountBalance();

        $this->comparePrice($accountBalance, $testResponse->getBalance());

        //test cache
        $newTestResponse = new TestUserGetAccountBalanceResponse();

        $frontendClient->setRequestClient($this->createTestRequestClient($newTestResponse));

        $accountBalance = $userContextWrapper->getAccountBalance();

        $this->comparePrice($accountBalance, $testResponse->getBalance());
        $this->assertNotEquals($accountBalance->getTag(), $newTestResponse->getBalance()->getTag());

        //test without cache

        $accountBalance = $userContextWrapper->getAccountBalance(false);

        $this->comparePrice($accountBalance, $newTestResponse->getBalance());
        $this->assertNotEquals($accountBalance->getTag(), $testResponse->getBalance()->getTag());
    }

    /**
     * @return void
     */
    public function testRemoveAccountBalanceCache() {
        $testResponse = new TestUserGetAccountBalanceResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $userContextWrapper = $this->createUserContextWrapper($frontendClient);

        $userContextWrapper->getAccountBalance();

        $frontendClient->setRequestClient($this->createTestRequestClient(new TestUserGetAccountBalanceResponse()));

        $accountBalance = $userContextWrapper
            ->removeAccountBalanceCache()
            ->getAccountBalance();

        $this->assertNotEquals($accountBalance->getTag(), $testResponse->getBalance()->getTag());
    }

    /**
     * @return void
     */
    public function testGetAuthTokens() {
        $testResponse = new TestUserGetTokensResponse();
        $testAuthTokens = $testResponse->getTokens();

        $frontendClient = $this->createFrontendClient($testResponse);

        $userContextWrapper = $this->createUserContextWrapper($frontendClient);

        $authTokens = $userContextWrapper->getAuthTokens();

        $this->assertEquals(\count($authTokens), \count($testAuthTokens));

        foreach ($authTokens as $authToken) {
            if (!isset($testAuthTokens[$authToken->getToken()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareAuthToken($authToken, $testAuthTokens[$authToken->getToken()]);
        }

        //test cache
        $newTestResponse = new TestUserGetTokensResponse();
        $newTestAuthTokens = $newTestResponse->getTokens();

        $frontendClient->setRequestClient($this->createTestRequestClient($newTestResponse));

        $authTokens = $userContextWrapper->getAuthTokens();

        $this->assertEquals(\count($authTokens), \count($testAuthTokens));

        foreach ($authTokens as $authToken) {
            if (!isset($testAuthTokens[$authToken->getToken()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareAuthToken($authToken, $testAuthTokens[$authToken->getToken()]);
        }

        foreach ($authTokens as $authToken) {
            $this->assertTrue(!isset($newTestAuthTokens[$authToken->getToken()]));
        }

        //test without cache
        $authTokens = $userContextWrapper->getAuthTokens(false);

        $this->assertEquals(\count($authTokens), \count($newTestAuthTokens));

        foreach ($authTokens as $authToken) {
            if (!isset($newTestAuthTokens[$authToken->getToken()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareAuthToken($authToken, $newTestAuthTokens[$authToken->getToken()]);
        }

        foreach ($authTokens as $authToken) {
            $this->assertTrue(!isset($testAuthTokens[$authToken->getToken()]));
        }
    }

    /**
     * @return void
     */
    public function testRemoveAuthTokensCache() {
        $testResponse = new TestUserGetTokensResponse();
        $testAuthTokens = $testResponse->getTokens();

        $frontendClient = $this->createFrontendClient($testResponse);

        $userContextWrapper = $this->createUserContextWrapper($frontendClient);

        $userContextWrapper->getAuthTokens();

        $frontendClient->setRequestClient($this->createTestRequestClient(new TestUserGetTokensResponse()));

        $authTokens = $userContextWrapper
            ->removeAuthTokensCache()
            ->getAuthTokens();

        foreach ($authTokens as $authToken) {
            $this->assertTrue(!isset($testAuthTokens[$authToken->getToken()]));
        }
    }

    /**
     * @return void
     */
    public function testChangeUserMetaData() {
        $testUser = UserMock::create(true);

        $testResponse = new TestUserChangeResponse($testUser);

        $userContextWrapper = $this->createUserContextWrapper($testResponse, $testUser);

        $testMetaData = [
            MockHelper::getFaker()->word => MockHelper::getFaker()->word,
        ];

        $user = $userContextWrapper
            ->changeUserMetaData($testMetaData)
            ->getUser();

        $testUser = UserMock::changeUserMetaData($testResponse->getUser(), $testMetaData);

        $this->compareUser($user, $testUser);
    }

    /**
     * @return void
     */
    public function testChangeUserPassword() {
        $testUser = UserMock::create(true);

        $testResponse = new TestUserChangePasswordResponse($testUser);

        $userContextWrapper = $this->createUserContextWrapper($testResponse, $testUser);

        $user = $userContextWrapper
            ->changeUserPassword(MockHelper::getFaker()->password)
            ->getUser();

        $this->compareUser($user, $testUser);
    }

    /**
     * @return void
     */
    public function testDeleteUser() {
        $userContextWrapper = $this->createUserContextWrapper(new TestUserDeleteResponse());

        $userContextWrapper->deleteUser();

        try {
            $userContextWrapper->getUser();

            $this->assertTrue(false);
        } catch (InvalidTokenException $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @return void
     */
    public function testDisableUserLogin() {
        $testUser = UserMock::create(true, false);
        $testResponse = new TestUserDisableLoginResponse($testUser);

        $userContextWrapper = $this->createUserContextWrapper($testResponse, $testUser);

        $user = $userContextWrapper
            ->disableUserLogin()
            ->getUser();

        $this->compareUser($user, UserMock::changeUserIsLoginDisabled($testResponse->getUser(), true));
    }

    /**
     * @return void
     */
    public function testEnableUserLogin() {
        $testUser = UserMock::create(true, true);
        $testResponse = new TestUserEnableLoginResponse($testUser);

        $userContextWrapper = $this->createUserContextWrapper($testResponse, $testUser);

        $user = $userContextWrapper
            ->enableUserLogin()
            ->getUser();

        $this->compareUser($user, UserMock::changeUserIsLoginDisabled($testResponse->getUser(), false));
    }

    /**
     * @return void
     */
    public function testCloseActiveFlexible() {
        $testResponse = new TestBillingCloseFlexibleResponse();

        $userContextWrapper = $this->createUserContextWrapper($testResponse, UserMock::create(true));

        $flexible = $userContextWrapper->getActiveFlexible();

        $this->compareFlexible($flexible, $testResponse->getFlexible());

        $userContextWrapper->closeActiveFlexible();

        try {
            $userContextWrapper->getActiveFlexible();

            $this->assertTrue(false);
        } catch (ObjectNotFoundException $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @return void
     */
    public function testConvertFromUserWithAuthToken() {
        $testUser = UserMock::create(true);

        $userContextWrapper = $this->createUserContextWrapper([], $testUser);

        $testUserWithoutToken = UserMock::changeAuthToken($testUser, null);

        $convertFromUserWithAuthTokenMethod = $this->getAccessibleMethod(
            'convertFromUserWithAuthToken',
            UserContextWrapper::class
        );

        $this->assertNotEquals($testUser->getAuthToken(), $testUserWithoutToken->getAuthToken());

        $user = $convertFromUserWithAuthTokenMethod->invokeArgs($userContextWrapper, [$testUserWithoutToken]);

        $this->compareUser($user, $testUser);
    }

    public function testGetUserIdentifierForClient() {
        $testUserWithToken = UserMock::create(true);

        $frontendClient = $this->createFrontendClient();

        $userContextWrapper = $this->createUserContextWrapper($frontendClient, $testUserWithToken);

        $getUserIdentifierForClientMethod = $this->getAccessibleMethod(
            'getUserIdentifierForClient',
            UserContextWrapper::class
        );

        $authToken = $getUserIdentifierForClientMethod->invokeArgs($userContextWrapper, []);

        $this->assertEquals($authToken, $testUserWithToken->getAuthToken()->getToken());

        $frontendClient->setForceTokenMode(false);

        $userId = $getUserIdentifierForClientMethod->invokeArgs($userContextWrapper, []);

        $this->assertEquals($userId, $testUserWithToken->getUserId());

        $userContextWrapper = $this->createUserContextWrapper(
            $frontendClient,
            UserMock::create(false)
        );

        $frontendClient->setForceTokenMode(true);

        try {
            $getUserIdentifierForClientMethod->invokeArgs($userContextWrapper, []);

            $this->assertTrue(false);
        } catch (InvalidTokenException $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @param FrontendClient|array|TestResponseInterface $frontendClient
     * @param UserObject|null                            $user
     *
     * @return UserContextWrapper
     */
    private function createUserContextWrapper($frontendClient, UserObject $user = null) {
        if (!($frontendClient instanceof FrontendClient)) {
            $frontendClient = $this->createFrontendClient($frontendClient);
        }

        return new UserContextWrapper(
            $frontendClient,
            $user
                ? $user
                : UserMock::create(true)
        );
    }

}