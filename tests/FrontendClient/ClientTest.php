<?php

use Ixolit\Dislo\Client;
use Ixolit\Dislo\Exceptions\AuthenticationException;
use Ixolit\Dislo\Exceptions\AuthenticationInvalidCredentialsException;
use Ixolit\Dislo\Exceptions\AuthenticationRateLimitedException;
use Ixolit\Dislo\Exceptions\DisloException;
use Ixolit\Dislo\Exceptions\InvalidTokenException;
use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\Response\BillingCloseActiveRecurringResponse;
use Ixolit\Dislo\Response\BillingCloseFlexibleResponse;
use Ixolit\Dislo\Response\BillingCreateFlexibleResponse;
use Ixolit\Dislo\Response\BillingCreatePaymentResponse;
use Ixolit\Dislo\Response\BillingExternalCreateChargebackResponse;
use Ixolit\Dislo\Response\BillingExternalCreateChargeResponse;
use Ixolit\Dislo\Response\BillingExternalGetProfileResponse;
use Ixolit\Dislo\Response\BillingGetActiveRecurringResponse;
use Ixolit\Dislo\Response\BillingGetEventResponse;
use Ixolit\Dislo\Response\BillingGetEventsForUserResponse;
use Ixolit\Dislo\Response\BillingGetFlexibleByIdentifierResponse;
use Ixolit\Dislo\Response\BillingGetFlexibleResponse;
use Ixolit\Dislo\Response\BillingMethodsGetAvailableResponse;
use Ixolit\Dislo\Response\BillingMethodsGetResponse;
use Ixolit\Dislo\Response\CouponCodeCheckResponse;
use Ixolit\Dislo\Response\CouponCodeValidateResponse;
use Ixolit\Dislo\Response\PackageGetResponse;
use Ixolit\Dislo\Response\PackagesListResponse;
use Ixolit\Dislo\Response\SubscriptionAttachCouponResponse;
use Ixolit\Dislo\Response\SubscriptionCalculateAddonPriceResponse;
use Ixolit\Dislo\Response\SubscriptionCalculatePackageChangeResponse;
use Ixolit\Dislo\Response\SubscriptionCalculatePriceResponse;
use Ixolit\Dislo\Response\SubscriptionCallSpiResponse;
use Ixolit\Dislo\Response\SubscriptionCancelPackageChangeResponse;
use Ixolit\Dislo\Response\SubscriptionCancelResponse;
use Ixolit\Dislo\Response\SubscriptionChangeResponse;
use Ixolit\Dislo\Response\SubscriptionCloseResponse;
use Ixolit\Dislo\Response\SubscriptionCreateAddonResponse;
use Ixolit\Dislo\Response\SubscriptionCreateResponse;
use Ixolit\Dislo\Response\SubscriptionExternalAddonCreateResponse;
use Ixolit\Dislo\Response\SubscriptionExternalChangePeriodResponse;
use Ixolit\Dislo\Response\SubscriptionExternalChangeResponse;
use Ixolit\Dislo\Response\SubscriptionExternalCloseResponse;
use Ixolit\Dislo\Response\SubscriptionExternalCreateResponse;
use Ixolit\Dislo\Response\SubscriptionFireEventResponse;
use Ixolit\Dislo\Response\SubscriptionGetAllResponse;
use Ixolit\Dislo\Response\SubscriptionGetPeriodEventsResponse;
use Ixolit\Dislo\Response\SubscriptionGetPossibleUpgradesResponse;
use Ixolit\Dislo\Response\SubscriptionGetResponse;
use Ixolit\Dislo\Response\UserAuthenticateResponse;
use Ixolit\Dislo\Response\UserChangePasswordResponse;
use Ixolit\Dislo\Response\UserChangeResponse;
use Ixolit\Dislo\Response\UserCreateResponse;
use Ixolit\Dislo\Response\UserDeauthenticateResponse;
use Ixolit\Dislo\Response\UserDeleteResponse;
use Ixolit\Dislo\Response\UserDisableLoginResponse;
use Ixolit\Dislo\Response\UserEmailVerificationFinishResponse;
use Ixolit\Dislo\Response\UserEmailVerificationStartResponse;
use Ixolit\Dislo\Response\UserEnableLoginResponse;
use Ixolit\Dislo\Response\UserFindResponse;
use Ixolit\Dislo\Response\UserFireEventResponse;
use Ixolit\Dislo\Response\UserGetAuthenticatedResponse;
use Ixolit\Dislo\Response\UserGetBalanceResponse;
use Ixolit\Dislo\Response\UserGetMetaProfileResponse;
use Ixolit\Dislo\Response\UserGetResponse;
use Ixolit\Dislo\Response\UserGetTokensResponse;
use Ixolit\Dislo\Response\UserPhoneVerificationFinishResponse;
use Ixolit\Dislo\Response\UserPhoneVerificationStartResponse;
use Ixolit\Dislo\Response\UserRecoveryCheckResponse;
use Ixolit\Dislo\Response\UserRecoveryFinishResponse;
use Ixolit\Dislo\Response\UserRecoveryStartResponse;
use Ixolit\Dislo\Response\UserSmsVerificationFinishResponse;
use Ixolit\Dislo\Response\UserSmsVerificationStartResponse;
use Ixolit\Dislo\Response\UserUpdateTokenResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\Response\TestBillingCloseActiveRecurringResponse;
use Ixolit\Dislo\Test\Response\TestBillingCloseFlexibleResponse;
use Ixolit\Dislo\Test\Response\TestBillingCreateFlexibleResponse;
use Ixolit\Dislo\Test\Response\TestBillingCreatePaymentResponse;
use Ixolit\Dislo\Test\Response\TestBillingExternalCreateChargebackByEventIdResponse;
use Ixolit\Dislo\Test\Response\TestBillingExternalCreateChargebackByTransactionIdResponse;
use Ixolit\Dislo\Test\Response\TestBillingExternalCreateChargeResponse;
use Ixolit\Dislo\Test\Response\TestBillingExternalGetProfileByExternalIdResponse;
use Ixolit\Dislo\Test\Response\TestBillingExternalGetProfileBySubscriptionIdResponse;
use Ixolit\Dislo\Test\Response\TestBillingGetActiveRecurringResponse;
use Ixolit\Dislo\Test\Response\TestBillingGetEventResponse;
use Ixolit\Dislo\Test\Response\TestBillingGetEventsForUserResponse;
use Ixolit\Dislo\Test\Response\TestBillingGetFlexibleByIdentifierResponse;
use Ixolit\Dislo\Test\Response\TestBillingGetFlexibleResponse;
use Ixolit\Dislo\Test\Response\TestBillingMethodsGetAvailableResponse;
use Ixolit\Dislo\Test\Response\TestBillingMethodsGetResponse;
use Ixolit\Dislo\Test\Response\TestCouponCodeCheckResponse;
use Ixolit\Dislo\Test\Response\TestCouponCodeValidateNewResponse;
use Ixolit\Dislo\Test\Response\TestCouponCodeValidateUpgradeResponse;
use Ixolit\Dislo\Test\Response\TestPackageGetResponse;
use Ixolit\Dislo\Test\Response\TestPackageListResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionAttachCouponResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionCalculateAddonPriceResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionCalculatePackageChange;
use Ixolit\Dislo\Test\Response\TestSubscriptionCalculatePriceResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionCallSpiResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionCancelPackageChangeResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionCancelResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionChangeResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionCloseResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionCreateAddonResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionCreateResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionExternalAddonCreateResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionExternalChangePeriodResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionExternalChangeResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionExternalCloseResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionExternalCreateResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionFireEventResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionGetAllResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionGetPeriodEventsResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionGetPossiblePackageChangesResponse;
use Ixolit\Dislo\Test\Response\TestSubscriptionGetResponse;
use Ixolit\Dislo\Test\Response\TestUserAuthenticateResponse;
use Ixolit\Dislo\Test\Response\TestUserChangePasswordResponse;
use Ixolit\Dislo\Test\Response\TestUserChangeResponse;
use Ixolit\Dislo\Test\Response\TestUserCreateResponse;
use Ixolit\Dislo\Test\Response\TestUserDeauthenticateResponse;
use Ixolit\Dislo\Test\Response\TestUserDeleteResponse;
use Ixolit\Dislo\Test\Response\TestUserDisableLoginResponse;
use Ixolit\Dislo\Test\Response\TestUserEmailVerificationFinishResponse;
use Ixolit\Dislo\Test\Response\TestUserEmailVerificationStartResponse;
use Ixolit\Dislo\Test\Response\TestUserEnableLoginResponse;
use Ixolit\Dislo\Test\Response\TestUserExtendTokenResponse;
use Ixolit\Dislo\Test\Response\TestUserFindResponse;
use Ixolit\Dislo\Test\Response\TestUserFireEventResponse;
use Ixolit\Dislo\Test\Response\TestUserGetAccountBalanceResponse;
use Ixolit\Dislo\Test\Response\TestUserGetAuthenticatedResponse;
use Ixolit\Dislo\Test\Response\TestUserGetMetaProfileResponse;
use Ixolit\Dislo\Test\Response\TestUserGetResponse;
use Ixolit\Dislo\Test\Response\TestUserGetTokensResponse;
use Ixolit\Dislo\Test\Response\TestUserPhoneVerificationFinishResponse;
use Ixolit\Dislo\Test\Response\TestUserPhoneVerificationStartResponse;
use Ixolit\Dislo\Test\Response\TestUserRecoveryCheckResponse;
use Ixolit\Dislo\Test\Response\TestUserRecoveryFinishResponse;
use Ixolit\Dislo\Test\Response\TestUserRecoveryStartResponse;
use Ixolit\Dislo\Test\Response\TestUserSmsVerificationFinishResponse;
use Ixolit\Dislo\Test\Response\TestUserSmsVerificationStartResponse;
use Ixolit\Dislo\Test\Response\TestUserUpdateTokenResponse;
use Ixolit\Dislo\Test\WorkingObjects\AuthTokenMock;
use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\Test\WorkingObjects\CouponMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class ClientTest
 */
final class ClientTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testUserToData() {

        //test the userToData function with a FrontendClient in forceTokenMode
        $frontendClientWithForceTokenMode = $this->createFrontendClient();

        $userToDataMethod = $this->getAccessibleMethod('userToData', Client::class);

        $authTokenObject = AuthTokenMock::create();

        $testData = [];

        //test auth token string
        $testData = $userToDataMethod->invokeArgs(
            $frontendClientWithForceTokenMode,
            [
                $authTokenObject->getToken(),
                &$testData
            ]
        );

        $this->assertArrayHasKey('authToken', $testData);
        $this->assertArrayNotHasKey('userId', $testData);
        $this->assertEquals($testData['authToken'], $authTokenObject->getToken());

        $testData = [];
        $testData = $userToDataMethod->invokeArgs($frontendClientWithForceTokenMode, [$authTokenObject, &$testData]);

        $this->assertArrayHasKey('authToken', $testData);
        $this->assertArrayNotHasKey('userId', $testData);
        $this->assertEquals($testData['authToken'], $authTokenObject->getToken());

        //test forceTokenMode = false
        $frontendClientWithoutForceTokenMode = $this->createFrontendClient([], false);

        //test user id as intC
        $userIdInt = MockHelper::getFaker()->randomNumber();

        $testData = [];
        $testData = $userToDataMethod->invokeArgs($frontendClientWithoutForceTokenMode, [$userIdInt, &$testData]);

        $this->assertArrayHasKey('userId', $testData);
        $this->assertArrayNotHasKey('authToken', $testData);
        $this->assertEquals($testData['userId'], $userIdInt);

        //test user id as string
        $userIdString = (string)MockHelper::getFaker()->randomNumber();

        $testData = [];
        $testData = $userToDataMethod->invokeArgs($frontendClientWithoutForceTokenMode, [$userIdString, &$testData]);

        $this->assertArrayHasKey('userId', $testData);
        $this->assertArrayNotHasKey('authToken', $testData);
        //userId will be casted to int
        $this->assertEquals($testData['userId'], (int)$userIdString);

        //test user object
        $userObject = UserMock::create();

        $testData = [];
        $testData = $userToDataMethod->invokeArgs($frontendClientWithoutForceTokenMode, [$userObject, &$testData]);

        $this->assertArrayHasKey('userId', $testData);
        $this->assertArrayNotHasKey('authToken', $testData);
        //userId will be casted to int
        $this->assertEquals($testData['userId'], $userObject->getUserId());

        //test false user id types

        //user id is null
        $userIdNull = null;
        $testData = [];
        $testData = $userToDataMethod->invokeArgs($frontendClientWithoutForceTokenMode, [$userIdNull, &$testData]);

        $this->assertArrayNotHasKey('userId', $testData);
        $this->assertArrayNotHasKey('authToken', $testData);

        foreach ([true, 1.00, [],] as $testUserId) {
            try {
                $testData = [];
                $userToDataMethod->invokeArgs($frontendClientWithoutForceTokenMode, [$testUserId, &$testData]);

                $this->assertTrue(false);
            } catch (\InvalidArgumentException $e) {
                $this->assertTrue(true);
            }
        }
    }

    /**
     * @return void
     */
    public function testRequest() {
        $requestMethod = $this->getAccessibleMethod('request', Client::class);

        //test correct response
        $frontendClient = $this->createFrontendClient([
            'success' => true,
        ]);

        $testResponse = $requestMethod->invokeArgs($frontendClient, ['/', []]);

        $this->assertArrayHasKey('success', $testResponse);
        $this->assertTrue($testResponse['success']);

        //test error response
        $errorResponse = [
            'success' => false,
            'errors'  => [
                [
                    'code'    => 404,
                    'message' => MockHelper::getFaker()->word,
                ],
            ],
        ];

        $frontendClient = $this->createFrontendClient($errorResponse);

        try {
            $requestMethod->invokeArgs($frontendClient, ['/', []]);

            $success = false;
        } catch (ObjectNotFoundException $e) {
            $success = true;
        }

        $this->assertTrue($success);

        $errorResponse['errors'][0]['code'] = 9002;

        $frontendClient = $this->createFrontendClient($errorResponse);

        try {
            $requestMethod->invokeArgs($frontendClient, ['/', []]);

            $success = false;
        } catch (InvalidTokenException $e) {
            $success = true;
        }

        $this->assertTrue($success);

        $errorResponse['errors'][0]['code'] = 9999;

        $frontendClient = $this->createFrontendClient($errorResponse);

        try {
            $requestMethod->invokeArgs($frontendClient, ['/', []]);

            $success = false;
        } catch (DisloException $e) {
            $success = true;
        }

        $this->assertTrue($success);
    }

    /**
     * @return void
     */
    public function testBillingMethodsGet() {
        $testResponseWithoutRequirements = new TestBillingMethodsGetResponse();
        $testBillingMethodsWithoutRequirements = $testResponseWithoutRequirements->getBillingMethodsWithoutRequirement();

        $frontendClient = $this->createFrontendClient($testResponseWithoutRequirements);

        $billingMethodsGetResponse = $frontendClient->billingMethodsGet();

        $this->assertTrue(($billingMethodsGetResponse instanceof BillingMethodsGetResponse));

        $billingMethods = $billingMethodsGetResponse->getBillingMethods();

        $this->assertEquals(\count($billingMethods), \count($testBillingMethodsWithoutRequirements));

        foreach ($billingMethods as $billingMethod) {
            if (!isset($testBillingMethodsWithoutRequirements[$billingMethod->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($billingMethod, $testBillingMethodsWithoutRequirements[$billingMethod->getName()]);
        }

        //test billingMethodsGet with package id
        $testBillingMethodsWithRequirements = $testResponseWithoutRequirements->getBillingMethodsWithRequirement();

        $billingMethodsForPackageGetResponse = $frontendClient->billingMethodsGet(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->countryCode
        );

        $this->assertTrue(($billingMethodsForPackageGetResponse instanceof BillingMethodsGetResponse));

        $billingMethods = $billingMethodsForPackageGetResponse->getBillingMethods();

        $this->assertEquals(\count($billingMethods), \count($testBillingMethodsWithRequirements));

        foreach ($billingMethods as $billingMethod) {
            if (!isset($testBillingMethodsWithRequirements[$billingMethod->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($billingMethod, $testBillingMethodsWithRequirements[$billingMethod->getName()]);
        }

    }

    /**
     * @return void
     */
    public function testBillingMethodsGetAvailable() {
        $testResponse= new TestBillingMethodsGetAvailableResponse();
        $testBillingMethods = $testResponse->getBillingMethods();

        $frontendClient = $this->createFrontendClient($testResponse);

        $billingMethodsGetAvailableResponse = $frontendClient->billingMethodsGetAvailable();

        $this->assertTrue(($billingMethodsGetAvailableResponse instanceof BillingMethodsGetAvailableResponse));

        $billingMethods = $billingMethodsGetAvailableResponse->getBillingMethods();

        $this->assertEquals(\count($billingMethods), \count($testBillingMethods));

        foreach ($billingMethods as $billingMethod) {
            if (!isset($testBillingMethods[$billingMethod->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($billingMethod, $testBillingMethods[$billingMethod->getName()]);
        }
    }

    /**
     * @return void
     */
    public function testBillingCloseFlexible() {
        $testResponse = new TestBillingCloseFlexibleResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingCloseFlexible(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue(($response instanceof BillingCloseFlexibleResponse));

        $this->compareFlexible($response->getFlexible(), $testResponse->getFlexible());
    }

    /**
     * @return void
     */
    public function testBillingCreateFlexible() {
        $testResponse = new TestBillingCreateFlexibleResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingCreateFlexible(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->url,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->randomNumber()
        );

        $this->assertTrue(($response instanceof BillingCreateFlexibleResponse));

        $this->compareFlexible($response->getFlexible(), $testResponse->getFlexible());
        $this->assertEquals($testResponse->getRedirectUrl(), $response->getRedirectUrl());
    }

    /**
     * @return void
     */
    public function testBillingCreatePayment() {
        $testResponse = new TestBillingCreatePaymentResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingCreatePayment(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->url,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->countryCode
        );

        $this->assertTrue(($response instanceof BillingCreatePaymentResponse));

        $this->assertEquals($response->getRedirectUrl(), $testResponse->getRedirectUrl());
        $this->assertEmpty(\array_diff($response->getMetaData(), $testResponse->getMetaData()));
        $this->compareBillingEvent($response->getBillingEvent(), $testResponse->getBillingEvent());
    }

    /**
     * @return void
     */
    public function testBillingExternalCreateCharge() {
        $testResponse = new TestBillingExternalCreateChargeResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingExternalCreateCharge(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->randomFloat(2),
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->randomNumber(),
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->words(3),
            BillingEventMock::randomstatus(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof BillingExternalCreateChargeResponse);

        $this->assertEquals($response->getBillingEventId(), $testResponse->getBillingEventId());
    }

    /**
     * @return void
     */
    public function testBillingExternalCreateChargebackByTransactionId() {
        $testResponse = new TestBillingExternalCreateChargebackByTransactionIdResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingExternalCreateChargebackByTransactionId(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->words(3),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof BillingExternalCreateChargebackResponse);
        $this->assertEquals($response->getBillingEventId(), $testResponse->getBillingEventId());
    }

    /**
     * @return void
     */
    public function testBillingExternalCreateChargebackByEventId() {
        $testResponse = new TestBillingExternalCreateChargebackByEventIdResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingExternalCreateChargebackByEventId(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->words(3),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof BillingExternalCreateChargebackResponse);
        $this->assertEquals($response->getBillingEventId(), $testResponse->getBillingEventId());
    }

    /**
     * @return void
     */
    public function testBillingExternalGetProfileByExternalId() {
        $testResponse = new TestBillingExternalGetProfileByExternalIdResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingExternalGetProfileByExternalId(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof BillingExternalGetProfileResponse);
        $this->compareExternalProfile($response->getExternalProfile(), $testResponse->getExternalProfile());
    }

    /**
     * @return void
     */
    public function testBillingExternalGetProfileBySubscriptionId() {
        $testResponse = new TestBillingExternalGetProfileBySubscriptionIdResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingExternalGetProfileBySubscriptionId(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof BillingExternalGetProfileResponse);
        $this->compareExternalProfile($response->getExternalProfile(), $testResponse->getExternalProfile());
    }

    /**
     * @return void
     */
    public function testBillingGetEvent() {
        $testResponse = new TestBillingGetEventResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingGetEvent(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof BillingGetEventResponse);
        $this->compareBillingEvent($response->getBillingEvent(), $testResponse->getBillingEvent());
    }

    /**
     * @return void
     */
    public function testBillingGetEventsForUser() {
        $testResponse = new TestBillingGetEventsForUserResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingGetEventsForUser(MockHelper::getFaker()->uuid);

        $this->assertTrue($response instanceof BillingGetEventsForUserResponse);
        $this->assertEquals($response->getTotalCount(), $testResponse->getTotalCount());

        $testBillingEvents = $testResponse->getBillingEvents();

        $this->assertEquals(\count($response->getBillingEvents()), \count($testBillingEvents));

        foreach ($response->getBillingEvents() as $billingEvent) {
            if (!isset($testBillingEvents[$billingEvent->getBillingEventId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingEvent($billingEvent, $testBillingEvents[$billingEvent->getBillingEventId()]);
        }
    }

    /**
     * @return void
     */
    public function testBillingGetFlexible() {
        $testResponse = new TestBillingGetFlexibleResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingGetFlexible(MockHelper::getFaker()->uuid);

        $this->assertTrue($response instanceof BillingGetFlexibleResponse);
        $this->compareFlexible($response->getFlexible(), $testResponse->getFlexible());
    }

    /**
     * @return void
     */
    public function testBillingGetFlexibleByIdentifier() {
        $testResponse = new TestBillingGetFlexibleByIdentifierResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingGetFlexibleByIdentifier(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof BillingGetFlexibleByIdentifierResponse);
        $this->compareFlexible($response->getFlexible(), $testResponse->getFlexible());
    }

    /**
     * @return void
     */
    public function testBillingGetActiveRecurring() {
        $testResponse = new TestBillingGetActiveRecurringResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingGetActiveRecurring(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof BillingGetActiveRecurringResponse);
        $this->compareRecurring($response->getRecurring(), $testResponse->getRecurring());
    }

    /**
     * @return void
     */
    public function testBillingCloseActiveRecurring() {
        $testResponse = new TestBillingCloseActiveRecurringResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingCloseActiveRecurring(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof BillingCloseActiveRecurringResponse);
        $this->compareRecurring($response->getRecurring(), $testResponse->getRecurring());
    }

    /**
     * @return void
     */
    public function testSubscriptionCalculateAddonPrice() {
        $testResponse = new TestSubscriptionCalculateAddonPriceResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionCalculateAddonPrice(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionCalculateAddonPriceResponse);
        $this->assertEquals($response->isNeedsBilling(), $testResponse->needsBilling());
        $this->comparePrice($response->getPrice(), $testResponse->getPrice());
    }

    /**
     * @return void
     */
    public function testSubscriptionCalculatePackageChange() {
        $testResponse = new TestSubscriptionCalculatePackageChange();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionCalculatePackageChange(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->uuid,
            [
                MockHelper::getFaker()->uuid,
            ]
        );

        $this->assertTrue($response instanceof SubscriptionCalculatePackageChangeResponse);
        $this->assertEquals($response->isNeedsBilling(), $testResponse->needsBilling());
        $this->assertEquals($response->isAppliedImmediately(), $testResponse->appliedImmediately());
        $this->comparePrice($response->getPrice(), $testResponse->getPrice());
        $this->comparePrice($response->getRecurringPrice(), $testResponse->getRecurringPrice());
    }

    /**
     * @return void
     */
    public function testSubscriptionCalculatePrice() {
        $testResponse = new TestSubscriptionCalculatePriceResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionCalculatePrice(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->word,
            [
                MockHelper::getFaker()->uuid,
            ],
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionCalculatePriceResponse);
        $this->comparePrice($response->getPrice(), $testResponse->getPrice());
        $this->comparePrice($response->getRecurringPrice(), $testResponse->getRecurringPrice());
    }

    /**
     * @return void
     */
    public function testSubscriptionCancelPackageChange() {
        $testResponse = new TestSubscriptionCancelPackageChangeResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionCancelPackageChange(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof  SubscriptionCancelPackageChangeResponse);

        $testSubscriptions = $testResponse->getSubscriptions();

        $this->assertEquals(\count($response->getSubscriptions()), \count($testSubscriptions));

        foreach ($response->getSubscriptions() as $subscription) {
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
    public function testSubscriptionCancel() {
        $testResponse = new TestSubscriptionCancelResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionCancel(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->words(3),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionCancelResponse);
        $this->compareSubscription($response->getSubscription(), $testResponse->getSubscription());
    }

    /**
     * @return void
     */
    public function testSubscriptionChange() {
        $testResponse = new TestSubscriptionChangeResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionChange(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid,
            [
                MockHelper::getFaker()->uuid,
            ],
            MockHelper::getFaker()->word,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionChangeResponse);
        $this->compareSubscription($response->getSubscription(), $testResponse->getSubscription());
        $this->assertEquals($response->needsBilling(), $testResponse->needsBilling());
        $this->comparePrice($response->getPrice(), $testResponse->getPrice());
        $this->assertEquals($response->requiresFlexible(), $testResponse->requiresFlexible());
        $this->assertEquals($response->isAppliedImmediately(), $testResponse->appliedImmediately());
    }

    /**
     * @return void
     */
    public function testCouponCodeCheck() {
        $couponCode = MockHelper::getFaker()->word;
        $event = CouponMock::randomEvent();

        $testResponse = new TestCouponCodeCheckResponse($couponCode, $event);

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->couponCodeCheck($couponCode, $event);

        $this->assertTrue($response instanceof CouponCodeCheckResponse);
        $this->assertEquals($response->getCouponCode(), $testResponse->getCouponCode());
        $this->assertEquals($response->getEvent(), $testResponse->getEvent());
        $this->assertEquals($response->getReason(), $testResponse->getReason());
        $this->assertEquals($response->isValid(), $testResponse->isValid());
    }

    /**
     * @return void
     */
    public function testSubscriptionClose() {
        $testResponse = new TestSubscriptionCloseResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionClose(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionCloseResponse);
        $this->compareSubscription($response->getSubscription(), $testResponse->getSubscription());
    }

    /**
     * @return void
     */
    public function testSubscriptionCreateAddon() {
        $testResponse = new TestSubscriptionCreateAddonResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionCreateAddon(
            MockHelper::getFaker()->randomNumber(),
            [
                MockHelper::getFaker()->uuid
            ],
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionCreateAddonResponse);
        $this->compareSubscription($response->getSubscription(), $testResponse->getSubscription());
        $this->assertEquals($response->isNeedsBilling(), $testResponse->needsBilling());
        $this->comparePrice($response->getPrice(), $testResponse->getPrice());
    }

    /**
     * @return void
     */
    public function testSubscriptionCreate() {
        $testResponse = new TestSubscriptionCreateResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionCreate(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->word,
            [
                MockHelper::getFaker()->uuid,
            ]
        );

        $this->assertTrue($response instanceof SubscriptionCreateResponse);
        $this->compareSubscription($response->getSubscription(), $testResponse->getSubscription());
        $this->assertEquals($response->needsBilling(), $testResponse->needsBilling());
        $this->comparePrice($response->getPrice(), $testResponse->getPrice());
        $this->assertEquals($response->requiresFlexible(), $testResponse->requiresFlexible());
    }

    /**
     * @return void
     */
    public function subscriptionExternalChange() {
        $testResponse = new TestSubscriptionExternalChangeResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionExternalChange(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->dateTime(),
            [
                MockHelper::getFaker()->uuid,
            ],
            MockHelper::getFaker()->randomNumber(),
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionExternalChangeResponse);
        $this->assertEquals($response->getUpgradeId(), $testResponse->getUpgradeId());
    }

    /**
     * @return void
     */
    public function testSubscriptionExternalChangePeriod() {
        $testResponse = new TestSubscriptionExternalChangePeriodResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionExternalChangePeriod(
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionExternalChangePeriodResponse);
        $this->compareSubscription($response->getSubscription(), $testResponse->getSubscription());
    }

    /**
     * @return void
     */
    public function testSubscriptionExternalClose() {
        $testResponse = new TestSubscriptionExternalCloseResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionExternalClose(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionExternalCloseResponse);
        $this->compareSubscription($response->getSubscription(), $testResponse->getSubscription());
    }

    /**
     * @return void
     */
    public function testSubscriptionExternalAddonCreate() {
        $testResponse = new TestSubscriptionExternalAddonCreateResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionExternalAddonCreate(
            MockHelper::getFaker()->randomNumber(),
            [
                MockHelper::getFaker()->uuid
            ],
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionExternalAddonCreateResponse);
        $this->compareSubscription($response->getSubscription(), $testResponse->getSubscription());
        $this->assertEquals($response->getUpgradeId(), $testResponse->getUpgradeId());
    }

    /**
     * @return void
     */
    public function testSubscriptionExternalCreate() {
        $testResponse = new TestSubscriptionExternalCreateResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionExternalCreate(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->currencyCode,
            [
                MockHelper::getFaker()->uuid,
            ],
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionExternalCreateResponse);
        $this->compareSubscription($response->getSubscription(), $testResponse->getSubscription());
    }

    /**
     * @return void
     */
    public function testSubscriptionCallSpi() {
        $testResponse = new TestSubscriptionCallSpiResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionCallSpi(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->word,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->randomNumber()
        );

        $this->assertTrue($response instanceof SubscriptionCallSpiResponse);
        $this->assertEmpty(\array_diff($response->getSpiResponse(), $testResponse->getSpiResponse()));
    }

    /**
     * @return void
     */
    public function testSubscriptionGetPossibleUpgrades() {
        $testResponse = new TestSubscriptionGetPossiblePackageChangesResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionGetPossibleUpgrades(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->randomNumber(),
            SubscriptionMock::randomPlanChangeType()
        );

        $this->assertTrue($response instanceof SubscriptionGetPossibleUpgradesResponse);

        $testPackages = $testResponse->getPackages();

        $this->assertEquals(\count($response->getPackages()), \count($testPackages));

        foreach ($response->getPackages() as $package) {
            if (!isset($testPackages[$package->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($package, $testPackages[$package->getPackageIdentifier()]);
        }
    }

    /**
     * @return void
     */
    public function testPackagesList() {
        $testResponse = new TestPackageListResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->packagesList(
            MockHelper::getFaker()->randomNumber()
        );

        $this->assertTrue($response instanceof PackagesListResponse);

        $testPackages = $testResponse->getPackages();

        $this->assertEquals(\count($response->getPackages()), \count($testPackages));

        foreach ($response->getPackages() as $package) {
            if (!isset($testPackages[$package->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($package, $testPackages[$package->getPackageIdentifier()]);
        }
    }

    /**
     * @return void
     */
    public function testPackageGet() {
        $testResponse = new TestPackageGetResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $testPackages = $testResponse->getPackages();
        $testPackage = \reset($testPackages);

        //test with correct package identifier
        try {
            $response = $frontendClient->packageGet(
                $testPackage->getPackageIdentifier()
            );

            $this->assertTrue($response instanceof PackageGetResponse);
            $this->comparePackage($response->getPackage(), $testPackage);
        } catch (ObjectNotFoundException $e) {
            $this->assertTrue(false);
        }

        //test with false package
        try {
            $frontendClient->packageGet(
                MockHelper::getFaker()->uuid
            );

            $this->assertTrue(false);
        } catch (ObjectNotFoundException $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @return void
     */
    public function testSubscriptionGet() {
        $testResponse = new TestSubscriptionGetResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionGet(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionGetResponse);
        $this->compareSubscription($response->getSubscription(), $testResponse->getSubscription());
    }

    /**
     * @return void
     */
    public function testSubscriptionGetAll() {
        $testResponse = new TestSubscriptionGetAllResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionGetAll(
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionGetAllResponse);

        $testSubscriptions = $testResponse->getSubscriptions();

        $this->assertEquals(\count($response->getSubscriptions()), \count($testSubscriptions));

        foreach ($response->getSubscriptions() as $subscription) {
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
    public function testSubscriptionGetPeriodEvents() {
        $testResponse = new TestSubscriptionGetPeriodEventsResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionGetPeriodEvents(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionGetPeriodEventsResponse);
        $this->assertEquals($response->getTotalCount(), $testResponse->getTotalCount());

        $testPeriodEvents = $testResponse->getPeriodEvents();

        $this->assertEquals(\count($response->getPeriodEvents()), \count($testPeriodEvents));

        foreach ($response->getPeriodEvents() as $periodEvent) {
            if (!isset($testPeriodEvents[$periodEvent->getPeriodEventId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePeriodEvent($periodEvent, $testPeriodEvents[$periodEvent->getPeriodEventId()]);
        }
    }

    /**
     * @return void
     */
    public function testSubscriptionAttachCoupon() {
        $testResponse = new TestSubscriptionAttachCouponResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionAttachCoupon(
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionAttachCouponResponse);
        $this->assertEquals($response->getAttached(), $testResponse->isAttached());
        $this->assertEquals($response->getReason(), $testResponse->getReason());
    }

    /**
     * @return void
     */
    public function testSubscriptionFireEvent() {
        $testResponse = new TestSubscriptionFireEventResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionFireEvent(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->word,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof SubscriptionFireEventResponse);
    }

    /**
     * @return void
     */
    public function testCouponCodeValidateNew() {
        $testResponse = new TestCouponCodeValidateNewResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->couponCodeValidateNew(
            $testResponse->getCouponCode(),
            MockHelper::getFaker()->uuid,
            [
                MockHelper::getFaker()->uuid,
            ],
            MockHelper::getFaker()->currencyCode
        );

        $this->assertTrue($response instanceof CouponCodeValidateResponse);
        $this->assertEquals($response->getCouponCode(), $testResponse->getCouponCode());
        $this->assertEquals($response->getEvent(), $testResponse->getEvent());
        $this->assertEquals($response->isValid(), $testResponse->isValid());
        $this->assertEquals($response->getReason(), $testResponse->getReason());
        $this->comparePrice($response->getDiscountedPrice(), $testResponse->getDiscountedPrice());
        $this->comparePrice($response->getRecurringPrice(), $testResponse->getRecurringPrice());
    }

    /**
     * @return void
     */
    public function testCouponCodeValidateUpgrade() {
        $testResponse = new TestCouponCodeValidateUpgradeResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->couponCodeValidateUpgrade(
            $testResponse->getCouponCode(),
            MockHelper::getFaker()->uuid,
            [
                MockHelper::getFaker()->uuid,
            ],
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof CouponCodeValidateResponse);
        $this->assertEquals($response->getCouponCode(), $testResponse->getCouponCode());
        $this->assertEquals($response->getEvent(), $testResponse->getEvent());
        $this->assertEquals($response->isValid(), $testResponse->isValid());
        $this->assertEquals($response->getReason(), $testResponse->getReason());
        $this->comparePrice($response->getDiscountedPrice(), $testResponse->getDiscountedPrice());
        $this->comparePrice($response->getRecurringPrice(), $testResponse->getRecurringPrice());
    }

    /**
     * @return void
     */
    public function testUserAuthenticate() {
        $testResponse = new TestUserAuthenticateResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        //success call
        $response = $frontendClient->userAuthenticate(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->ipv4,
            MockHelper::getFaker()->randomNumber(),
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->languageCode
        );

        $this->assertTrue($response instanceof UserAuthenticateResponse);
        $this->assertEquals($response->getAuthToken(), $testResponse->getAuthToken());
        $this->compareUser($response->getUser(), $testResponse->getUser());

        //authentication errors
        $testResponse = new TestUserAuthenticateResponse(TestUserAuthenticateResponse::ERROR_RATE_LIMIT);

        $frontendClient = $this->createFrontendClient($testResponse);

        try {
            $frontendClient->userAuthenticate(
                MockHelper::getFaker()->uuid,
                MockHelper::getFaker()->word,
                MockHelper::getFaker()->ipv4,
                MockHelper::getFaker()->randomNumber(),
                [
                    MockHelper::getFaker()->word => MockHelper::getFaker()->word,
                ],
                MockHelper::getFaker()->boolean(),
                MockHelper::getFaker()->languageCode
            );

            $this->assertTrue(false);
        } catch (AuthenticationRateLimitedException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        $testResponse = new TestUserAuthenticateResponse(TestUserAuthenticateResponse::ERROR_INVALID_CREDENTIALS);
        $frontendClient = $this->createFrontendClient($testResponse);

        try {
            $frontendClient->userAuthenticate(
                MockHelper::getFaker()->uuid,
                MockHelper::getFaker()->word,
                MockHelper::getFaker()->ipv4,
                MockHelper::getFaker()->randomNumber(),
                [
                    MockHelper::getFaker()->word => MockHelper::getFaker()->word,
                ],
                MockHelper::getFaker()->boolean(),
                MockHelper::getFaker()->languageCode
            );

            $this->assertTrue(false);
        } catch (AuthenticationInvalidCredentialsException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        $testResponse = new TestUserAuthenticateResponse('false_error_code');
        $frontendClient = $this->createFrontendClient($testResponse);

        try {
            $frontendClient->userAuthenticate(
                MockHelper::getFaker()->uuid,
                MockHelper::getFaker()->word,
                MockHelper::getFaker()->ipv4,
                MockHelper::getFaker()->randomNumber(),
                [
                    MockHelper::getFaker()->word => MockHelper::getFaker()->word,
                ],
                MockHelper::getFaker()->boolean(),
                MockHelper::getFaker()->languageCode
            );

            $this->assertTrue(false);
        } catch (AuthenticationException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

    /**
     * @return void
     */
    public function testUserDeauthenticate() {
        $testResponse = new TestUserDeauthenticateResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userDeauthenticate(
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof UserDeauthenticateResponse);
    }

    /**
     * @return void
     */
    public function testUserChange() {
        $testResponse = new TestUserChangeResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $newMetaData = [
            MockHelper::getFaker()->word => MockHelper::getFaker()->word,
        ];

        $response = $frontendClient->userChange(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->languageCode,
            $newMetaData
        );

        $testUser = UserMock::changeUserMetaData($testResponse->getUser(), $newMetaData);

        $this->assertTrue($response instanceof UserChangeResponse);
        $this->compareUser($response->getUser(), $testUser);
    }

    /**
     * @return void
     */
    public function testUserChangePassword() {
        $testResponse = new TestUserChangePasswordResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userChangePassword(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->password
        );

        $this->assertTrue($response instanceof UserChangeResponse);
        $this->compareUser($response->getUser(), $testResponse->getUser());
    }

    /**
     * @return void
     */
    public function testUserCreate() {
        $testResponse = new TestUserCreateResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userCreate(
            MockHelper::getFaker()->languageCode,
            MockHelper::getFaker()->password,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ]
        );

        $this->assertTrue($response instanceof UserCreateResponse);
        $this->compareUser($response->getUser(), $testResponse->getUser());
    }

    /**
     * @return void
     */
    public function testUserDelete() {
        $testResponse = new TestUserDeleteResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userDelete(
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof UserDeleteResponse);
    }

    /**
     * @return void
     */
    public function testUserDisableLogin() {
        $testResponse = new TestUserDisableLoginResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userDisableLogin(
            MockHelper::getFaker()->uuid
        );

        $testUser = UserMock::changeUserIsLoginDisabled($testResponse->getUser(), true);

        $this->assertTrue($response instanceof UserDisableLoginResponse);
        $this->compareUser($response->getUser(), $testUser);
    }

    /**
     * @return void
     */
    public function testUserEnableLogin() {
        $testResponse = new TestUserEnableLoginResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userEnableLogin(MockHelper::getFaker()->uuid);

        $testUser = UserMock::changeUserIsLoginDisabled($testResponse->getUser(), false);

        $this->assertTrue($response instanceof UserEnableLoginResponse);
        $this->compareUser($response->getUser(), $testUser);
    }

    /**
     * @return void
     */
    public function testUserGetAccountBalance() {
        $testResponse = new TestUserGetAccountBalanceResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userGetBalance(
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof UserGetBalanceResponse);
        $this->comparePrice($response->getBalance(), $testResponse->getBalance());
    }

    /**
     * @return void
     */
    public function testUserGetMetaProfile() {
        $testResponse = new TestUserGetMetaProfileResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userGetMetaProfile();

        $this->assertTrue($response instanceof UserGetMetaProfileResponse);

        $testMetaProfileElements = $testResponse->getElements();

        $this->assertEquals(\count($response->getElements()), \count($testMetaProfileElements));

        foreach ($response->getElements() as $element) {
            if (!isset($testMetaProfileElements[$element->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareMetaProfileElement($element, $testMetaProfileElements[$element->getName()]);
        }
    }

    /**
     * @return void
     */
    public function testUserGetTokens() {
        $testResponse = new TestUserGetTokensResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userGetTokens(
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof UserGetTokensResponse);

        $testAuthTokens = $testResponse->getTokens();

        $this->assertEquals(\count($response->getTokens()), \count($testAuthTokens));

        foreach ($response->getTokens() as $token) {
            if (!isset($testAuthTokens[$token->getToken()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareAuthToken($token, $testAuthTokens[$token->getToken()]);
        }
    }

    /**
     * @return void
     */
    public function testUserGet() {
        $testResponse = new TestUserGetResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userGet(
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof UserGetResponse);
        $this->compareUser($response->getUser(), $testResponse->getUser());
    }

    /**
     * @return void
     */
    public function testUserUpdateToken() {
        $testResponse = new TestUserUpdateTokenResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userUpdateToken(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->ipv4
        );

        $this->assertTrue($response instanceof UserUpdateTokenResponse);
        $this->compareAuthToken($response->getAuthToken(), $testResponse->getAuthToken());
    }

    /**
     * @return void
     */
    public function testUserExtendToken() {
        $testResponse = new TestUserExtendTokenResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userExtendToken(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->ipv4,
            MockHelper::getFaker()->randomNumber()
        );

        $this->assertTrue($response instanceof UserUpdateTokenResponse);
        $this->compareAuthToken($response->getAuthToken(), $testResponse->getAuthToken());
    }

    /**
     * @return void
     */
    public function testUserGetAuthenticated() {
        $testResponse = new TestUserGetAuthenticatedResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userGetAuthenticated(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->ipv4
        );

        $this->assertTrue($response instanceof UserGetAuthenticatedResponse);
        $this->compareUser($response->getUser(), $testResponse->getUser());
    }

    /**
     * @return void
     */
    public function testUserFind() {
        $testResponse = new TestUserFindResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userFind(
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof UserFindResponse);
        $this->compareUser($response->getUser(), $testResponse->getUser());
    }

    /**
     * @return void
     */
    public function testUserRecoveryStart() {
        $testResponse = new TestUserRecoveryStartResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userRecoveryStart(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->ipv4,
            MockHelper::getFaker()->url
        );

        $this->assertTrue($response instanceof UserRecoveryStartResponse);
    }

    /**
     * @return void
     */
    public function testUserRecoveryCheck() {
        $testResponse = new TestUserRecoveryCheckResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userRecoveryCheck(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->ipv4
        );

        $this->assertTrue($response instanceof UserRecoveryCheckResponse);
        $this->assertEquals($response->isValid(), $testResponse->isValid());
    }

    /**
     * @return void
     */
    public function testUserRecoveryFinish() {
        $testResponse = new TestUserRecoveryFinishResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userRecoveryFinish(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->ipv4,
            MockHelper::getFaker()->password
        );

        $this->assertTrue($response instanceof UserRecoveryFinishResponse);
        $this->compareUser($response->getUser(), $testResponse->getUser());
    }

    /**
     * @return void
     */
    public function testUserEmailVerificationStart() {
        $testResponse = new TestUserEmailVerificationStartResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userEmailVerificationStart(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->ipv4,
            MockHelper::getFaker()->url
        );

        $this->assertTrue($response instanceof UserEmailVerificationStartResponse);
    }

    /**
     * @return void
     */
    public function testUserEmailVerificationFinish() {
        $testResponse = new TestUserEmailVerificationFinishResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userEmailVerificationFinish(
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof UserEmailVerificationFinishResponse);
        $this->compareUser($response->getUser(), $testResponse->getUser());
    }

    /**
     * @return void
     */
    public function testUserPhoneVerificationStart() {
        $testResponse = new TestUserPhoneVerificationStartResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userPhoneVerificationStart(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->ipv4,
            MockHelper::getFaker()->phoneNumber
        );

        $this->assertTrue($response instanceof  UserPhoneVerificationStartResponse);
    }

    /**
     * @return void
     */
    public function testUserPhoneVerificationFinish() {
        $testResponse = new TestUserPhoneVerificationFinishResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userPhoneVerificationFinish(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->randomNumber(4),
            MockHelper::getFaker()->phoneNumber
        );

        $this->assertTrue($response instanceof UserPhoneVerificationFinishResponse);
        $this->compareUser($response->getUser(), $testResponse->getUser());
        $this->assertEquals($response->getVerifiedAt(), $testResponse->getVerifiedAt());
    }

    /**
     * @return void
     */
    public function testUserSmsVerificationStart() {
        $testResponse = new TestUserSmsVerificationStartResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userSmsVerificationStart(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->ipv4,
            MockHelper::getFaker()->phoneNumber
        );

        $this->assertTrue($response instanceof UserSmsVerificationStartResponse);
    }

    /**
     * @return void
     */
    public function testUserSmsVerificationFinish() {
        $testResponse = new TestUserSmsVerificationFinishResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userSmsVerificationFinish(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->randomNumber(4),
            MockHelper::getFaker()->phoneNumber
        );

        $this->assertTrue($response instanceof UserSmsVerificationFinishResponse);
        $this->compareUser($response->getUser(), $testResponse->getUser());
        $this->assertEquals($response->getVerifiedAt(), $testResponse->getVerifiedAt());
    }

    /**
     * @return void
     */
    public function testUserFireEvent() {
        $testResponse = new TestUserFireEventResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userFireEvent(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->word,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ]
        );

        $this->assertTrue($response instanceof UserFireEventResponse);
    }

}