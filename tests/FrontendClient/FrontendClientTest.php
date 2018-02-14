<?php


use Ixolit\Dislo\Exceptions\AuthenticationException;
use Ixolit\Dislo\Exceptions\AuthenticationInvalidCredentialsException;
use Ixolit\Dislo\Exceptions\AuthenticationRateLimitedException;
use Ixolit\Dislo\Exceptions\DisloException;
use Ixolit\Dislo\Exceptions\InvalidTokenException;
use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\FrontendClient;
use Ixolit\Dislo\Response\Billing\BillingCloseActiveRecurringResponseObject;
use Ixolit\Dislo\Response\Billing\BillingCloseFlexibleResponseObject;
use Ixolit\Dislo\Response\Billing\BillingCreateFlexibleResponseObject;
use Ixolit\Dislo\Response\Billing\BillingCreatePaymentResponseObject;
use Ixolit\Dislo\Response\Billing\BillingExternalCreateChargebackByEventIdResponseObject;
use Ixolit\Dislo\Response\Billing\BillingExternalCreateChargebackByTransactionIdResponseObject;
use Ixolit\Dislo\Response\Billing\BillingExternalCreateChargeResponseObject;
use Ixolit\Dislo\Response\Billing\BillingExternalGetProfileByExternalIdResponseObject;
use Ixolit\Dislo\Response\Billing\BillingExternalGetProfileBySubscriptionIdResponseObject;
use Ixolit\Dislo\Response\Billing\BillingGetActiveRecurringResponseObject;
use Ixolit\Dislo\Response\Billing\BillingGetEventResponseObject;
use Ixolit\Dislo\Response\Billing\BillingGetEventsForUserResponseObject;
use Ixolit\Dislo\Response\Billing\BillingGetFlexibleByIdentifierResponseObject;
use Ixolit\Dislo\Response\Billing\BillingGetFlexibleResponseObject;
use Ixolit\Dislo\Response\Billing\BillingMethodsGetAvailableResponseObject;
use Ixolit\Dislo\Response\Billing\BillingMethodsGetResponseObject;
use Ixolit\Dislo\Response\Subscription\CouponCodeCheckResponseObject;
use Ixolit\Dislo\Response\Subscription\CouponCodeValidateNewResponseObject;
use Ixolit\Dislo\Response\Subscription\CouponCodeValidateUpgradeResponseObject;
use Ixolit\Dislo\Response\Subscription\PackageGetResponseObject;
use Ixolit\Dislo\Response\Subscription\PackagesListResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionAttachCouponResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionCalculateAddonPriceResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionCalculatePackageChangeResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionCalculatePriceResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionCallSpiResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionCancelPackageChangeResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionCancelResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionChangeResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionCloseResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionCreateAddonResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionCreateResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionExternalAddonCreateResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionExternalChangePeriodResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionExternalChangeResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionExternalCloseResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionExternalCreateResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionFireEventResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionGetAllResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionGetPeriodEventsResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionGetPossiblePackageChangesResponseObject;
use Ixolit\Dislo\Response\Subscription\SubscriptionGetResponseObject;
use Ixolit\Dislo\Response\User\UserAuthenticateResponseObject;
use Ixolit\Dislo\Response\User\UserChangePasswordResponseObject;
use Ixolit\Dislo\Response\User\UserChangeResponseObject;
use Ixolit\Dislo\Response\User\UserCreateResponseObject;
use Ixolit\Dislo\Response\User\UserDeauthenticateResponseObject;
use Ixolit\Dislo\Response\User\UserDeleteResponseObject;
use Ixolit\Dislo\Response\User\UserDisableLoginResponseObject;
use Ixolit\Dislo\Response\User\UserEmailVerificationFinishResponseObject;
use Ixolit\Dislo\Response\User\UserEmailVerificationStartResponseObject;
use Ixolit\Dislo\Response\User\UserEnableLoginResponseObject;
use Ixolit\Dislo\Response\User\UserExtendTokenResponseObject;
use Ixolit\Dislo\Response\User\UserFindResponseObject;
use Ixolit\Dislo\Response\User\UserFireEventResponseObject;
use Ixolit\Dislo\Response\User\UserGetAuthenticatedResponseObject;
use Ixolit\Dislo\Response\User\UserGetBalanceResponseObject;
use Ixolit\Dislo\Response\User\UserGetMetaProfileResponseObject;
use Ixolit\Dislo\Response\User\UserGetResponseObject;
use Ixolit\Dislo\Response\User\UserGetTokensResponseObject;
use Ixolit\Dislo\Response\User\UserPhoneVerificationFinishResponseObject;
use Ixolit\Dislo\Response\User\UserPhoneVerificationStartResponseObject;
use Ixolit\Dislo\Response\User\UserRecoveryCheckResponseObject;
use Ixolit\Dislo\Response\User\UserRecoveryFinishResponseObject;
use Ixolit\Dislo\Response\User\UserRecoveryStartResponseObject;
use Ixolit\Dislo\Response\User\UserSmsVerificationFinishResponseObject;
use Ixolit\Dislo\Response\User\UserSmsVerificationStartResponseObject;
use Ixolit\Dislo\Response\User\UserUpdateTokenResponseObject;
use Ixolit\Dislo\Test\Request\TestRequestClient;
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
use Ixolit\Dislo\Test\Response\TestResponseInterface;
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
use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\Test\WorkingObjects\CouponMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\Billing\BillingEventObject;
use Ixolit\Dislo\WorkingObjects\Billing\BillingMethodObject;
use Ixolit\Dislo\WorkingObjects\Billing\ExternalProfileObject;
use Ixolit\Dislo\WorkingObjects\Billing\FlexibleObject;
use Ixolit\Dislo\WorkingObjects\Billing\RecurringObject;
use Ixolit\Dislo\WorkingObjects\Subscription\CouponObject;
use Ixolit\Dislo\WorkingObjects\Subscription\CouponUsageObject;
use Ixolit\Dislo\WorkingObjects\Subscription\DisplayNameObject;
use Ixolit\Dislo\WorkingObjects\Subscription\NextPackageObject;
use Ixolit\Dislo\WorkingObjects\Subscription\PackageObject;
use Ixolit\Dislo\WorkingObjects\Subscription\PackagePeriodObject;
use Ixolit\Dislo\WorkingObjects\Subscription\PeriodEventObject;
use Ixolit\Dislo\WorkingObjects\Subscription\PriceObject;
use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;
use Ixolit\Dislo\WorkingObjects\User\AuthTokenObject;
use Ixolit\Dislo\WorkingObjects\User\MetaProfileElementObject;
use Ixolit\Dislo\WorkingObjects\User\UserObject;
use PHPUnit\Framework\TestCase;

/**
 * Class FrontendClientTest
 */
final class FrontendClientTest extends TestCase{

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @return void
     */
    public function testUserToData() {

        //test the userToData function with a FrontendClient in forceTokenMode
        $frontendClientWithForceTokenMode = $this->createFrontendClient();

        $userToDataMethod = $this->getAccessibleMethod('userToData');

        $authToken = MockHelper::getFaker()->uuid;

        //test auth token string
        $testData = $userToDataMethod->invokeArgs($frontendClientWithForceTokenMode, [$authToken, []]);

        $this->assertArrayHasKey('authToken', $testData);
        $this->assertArrayNotHasKey('userId', $testData);
        $this->assertEquals($testData['authToken'], $authToken);

        $authTokenObject = new AuthTokenObject(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->randomNumber(),
            $authToken,
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->word
        );

        $testData = $userToDataMethod->invokeArgs($frontendClientWithForceTokenMode, [$authTokenObject, []]);

        $this->assertArrayHasKey('authToken', $testData);
        $this->assertArrayNotHasKey('userId', $testData);
        $this->assertEquals($testData['authToken'], $authToken);

        //test forceTokenMode = false
        $frontendClientWithoutForceTokenMode = $this->createFrontendClient([], false);

        //test user id as intC
        $userIdInt = MockHelper::getFaker()->randomNumber();

        $testData = $userToDataMethod->invokeArgs($frontendClientWithoutForceTokenMode, [$userIdInt, []]);

        $this->assertArrayHasKey('userId', $testData);
        $this->assertArrayNotHasKey('authToken', $testData);
        $this->assertEquals($testData['userId'], $userIdInt);

        //test user id as string
        $userIdString = (string)MockHelper::getFaker()->randomNumber();

        $testData = $userToDataMethod->invokeArgs($frontendClientWithoutForceTokenMode, [$userIdString, []]);

        $this->assertArrayHasKey('userId', $testData);
        $this->assertArrayNotHasKey('authToken', $testData);
        //userId will be casted to int
        $this->assertEquals($testData['userId'], (int)$userIdString);

        //test user object
        $userObject = UserMock::create();

        $testData = $userToDataMethod->invokeArgs($frontendClientWithoutForceTokenMode, [$userObject, []]);

        $this->assertArrayHasKey('userId', $testData);
        $this->assertArrayNotHasKey('authToken', $testData);
        //userId will be casted to int
        $this->assertEquals($testData['userId'], $userObject->getUserId());

        //test false user id types

        //user id is null
        $userIdNull = null;
        $testData = $userToDataMethod->invokeArgs($frontendClientWithoutForceTokenMode, [$userIdNull, []]);

        $this->assertArrayNotHasKey('userId', $testData);
        $this->assertArrayNotHasKey('authToken', $testData);

        foreach ([true, 1.00, [],] as $testUserId) {
            try {
                $userToDataMethod->invokeArgs($frontendClientWithoutForceTokenMode, [$testUserId, []]);

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
        $frontendClient = $this->createFrontendClient([]);

        $requestMethod = $this->getAccessibleMethod('request');

        //test correct response
        $frontendClient->setRequestClient($this->createTestRequestClient([
            'success' => true,
        ]));

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

        $frontendClient->setRequestClient($this->createTestRequestClient($errorResponse));

        try {
            $requestMethod->invokeArgs($frontendClient, ['/', []]);

            $success = false;
        } catch (ObjectNotFoundException $e) {
            $success = true;
        }

        $this->assertTrue($success);

        $errorResponse['errors'][0]['code'] = 9002;

        $frontendClient->setRequestClient($this->createTestRequestClient($errorResponse));

        try {
            $requestMethod->invokeArgs($frontendClient, ['/', []]);

            $success = false;
        } catch (InvalidTokenException $e) {
            $success = true;
        }

        $this->assertTrue($success);

        $errorResponse['errors'][0]['code'] = 9999;

        $frontendClient->setRequestClient($this->createTestRequestClient($errorResponse));

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

        $this->assertTrue(($billingMethodsGetResponse instanceof BillingMethodsGetResponseObject));

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

        $this->assertTrue(($billingMethodsForPackageGetResponse instanceof BillingMethodsGetResponseObject));

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

        $this->assertTrue(($billingMethodsGetAvailableResponse instanceof BillingMethodsGetAvailableResponseObject));

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

        $this->assertTrue(($response instanceof BillingCloseFlexibleResponseObject));

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

        $this->assertTrue(($response instanceof BillingCreateFlexibleResponseObject));

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

        $this->assertTrue(($response instanceof BillingCreatePaymentResponseObject));

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

        $this->assertTrue($response instanceof BillingExternalCreateChargeResponseObject);

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

        $this->assertTrue($response instanceof BillingExternalCreateChargebackByTransactionIdResponseObject);
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

        $this->assertTrue($response instanceof BillingExternalCreateChargebackByEventIdResponseObject);
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

        $this->assertTrue($response instanceof BillingExternalGetProfileByExternalIdResponseObject);
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

        $this->assertTrue($response instanceof BillingExternalGetProfileBySubscriptionIdResponseObject);
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

        $this->assertTrue($response instanceof BillingGetEventResponseObject);
        $this->compareBillingEvent($response->getBillingEvent(), $testResponse->getBillingEvent());
    }

    /**
     * @return void
     */
    public function testBillingGetEventsForUser() {
        $testResponse = new TestBillingGetEventsForUserResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->billingGetEventsForUser(MockHelper::getFaker()->uuid);

        $this->assertTrue($response instanceof BillingGetEventsForUserResponseObject);
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

        $this->assertTrue($response instanceof BillingGetFlexibleResponseObject);
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

        $this->assertTrue($response instanceof BillingGetFlexibleByIdentifierResponseObject);
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

        $this->assertTrue($response instanceof BillingGetActiveRecurringResponseObject);
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

        $this->assertTrue($response instanceof BillingCloseActiveRecurringResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionCalculateAddonPriceResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionCalculatePackageChangeResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionCalculatePriceResponseObject);
        $this->assertEquals($response->isNeedsBilling(), $testResponse->needsBilling());
        $this->assertEquals($response->isAppliedImmediately(), $testResponse->appliedImmediately());
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

        $this->assertTrue($response instanceof  SubscriptionCancelPackageChangeResponseObject);

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

        $this->assertTrue($response instanceof SubscriptionCancelResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionChangeResponseObject);
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

        $this->assertTrue($response instanceof CouponCodeCheckResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionCloseResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionCreateAddonResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionCreateResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionExternalChangeResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionExternalChangePeriodResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionExternalCloseResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionExternalAddonCreateResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionExternalCreateResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionCallSpiResponseObject);
        $this->assertEmpty(\array_diff($response->getSpiResponse(), $testResponse->getSpiResponse()));
    }

    /**
     * @return void
     */
    public function testSubscriptionGetPossiblePackageChanges() {
        $testResponse = new TestSubscriptionGetPossiblePackageChangesResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->subscriptionGetPossiblePackageChanges(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->randomNumber(),
            SubscriptionMock::randomPlanChangeType()
        );

        $this->assertTrue($response instanceof SubscriptionGetPossiblePackageChangesResponseObject);

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
    public function testPackageList() {
        $testResponse = new TestPackageListResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->packageList(
            MockHelper::getFaker()->randomNumber()
        );

        $this->assertTrue($response instanceof PackagesListResponseObject);

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

            $this->assertTrue($response instanceof PackageGetResponseObject);
            $this->comparePackage($response->getPackage(), $testPackage);
        } catch (ObjectNotFoundException $e) {
            $this->assertTrue(false);
        }

        //test with false package
        try {
            $response = $frontendClient->packageGet(
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

        $this->assertTrue($response instanceof SubscriptionGetResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionGetAllResponseObject);

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

        $this->assertTrue($response instanceof SubscriptionGetPeriodEventsResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionAttachCouponResponseObject);
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

        $this->assertTrue($response instanceof SubscriptionFireEventResponseObject);
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

        $this->assertTrue($response instanceof CouponCodeValidateNewResponseObject);
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

        $this->assertTrue($response instanceof CouponCodeValidateUpgradeResponseObject);
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

        $this->assertTrue($response instanceof UserAuthenticateResponseObject);
        $this->assertEquals($response->getAuthToken(), $testResponse->getAuthToken());
        $this->compareUser($response->getUser(), $testResponse->getUser());

        //authentication errors
        $testResponse = new TestUserAuthenticateResponse(TestUserAuthenticateResponse::ERROR_RATE_LIMIT);
        $frontendClient->setRequestClient($this->createTestRequestClient($testResponse));

        try {
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

            $this->assertTrue(false);
        } catch (AuthenticationRateLimitedException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        $testResponse = new TestUserAuthenticateResponse(TestUserAuthenticateResponse::ERROR_INVALID_CREDENTIALS);
        $frontendClient->setRequestClient($this->createTestRequestClient($testResponse));

        try {
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

            $this->assertTrue(false);
        } catch (AuthenticationInvalidCredentialsException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        $testResponse = new TestUserAuthenticateResponse('false_error_code');
        $frontendClient->setRequestClient($this->createTestRequestClient($testResponse));

        try {
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

        $this->assertTrue($response instanceof UserDeauthenticateResponseObject);
    }

    /**
     * @return void
     */
    public function testUserChange() {
        $testResoonse = new TestUserChangeResponse();

        $frontendClient = $this->createFrontendClient($testResoonse);

        $response = $frontendClient->userChange(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->languageCode,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ]
        );

        $this->assertTrue($response instanceof UserChangeResponseObject);
        $this->compareUser($response->getUser(), $testResoonse->getUser());
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

        $this->assertTrue($response instanceof UserChangePasswordResponseObject);
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

        $this->assertTrue($response instanceof UserCreateResponseObject);
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

        $this->assertTrue($response instanceof UserDeleteResponseObject);
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

        $this->assertTrue($response instanceof UserDisableLoginResponseObject);
        $this->compareUser($response->getUser(), $testResponse->getUser());
    }

    /**
     * @return void
     */
    public function testUserEnableLogin() {
        $testResponse = new TestUserEnableLoginResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userEnableLogin(
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof UserEnableLoginResponseObject);
        $this->compareUser($response->getUser(), $testResponse->getUser());
    }

    /**
     * @return void
     */
    public function testUserGetAccountBalance() {
        $testResponse = new TestUserGetAccountBalanceResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userGetAccountBalance(
            MockHelper::getFaker()->uuid
        );

        $this->assertTrue($response instanceof UserGetBalanceResponseObject);
        $this->comparePrice($response->getBalance(), $testResponse->getBalance());
    }

    /**
     * @return void
     */
    public function testUserGetMetaProfile() {
        $testResponse = new TestUserGetMetaProfileResponse();

        $frontendClient = $this->createFrontendClient($testResponse);

        $response = $frontendClient->userGetMetaProfile();

        $this->assertTrue($response instanceof UserGetMetaProfileResponseObject);

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

        $this->assertTrue($response instanceof UserGetTokensResponseObject);

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

        $this->assertTrue($response instanceof UserGetResponseObject);
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

        $this->assertTrue($response instanceof UserUpdateTokenResponseObject);
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

        $this->assertTrue($response instanceof UserExtendTokenResponseObject);
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

        $this->assertTrue($response instanceof UserGetAuthenticatedResponseObject);
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

        $this->assertTrue($response instanceof UserFindResponseObject);
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

        $this->assertTrue($response instanceof UserRecoveryStartResponseObject);
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

        $this->assertTrue($response instanceof UserRecoveryCheckResponseObject);
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

        $this->assertTrue($response instanceof UserRecoveryFinishResponseObject);
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

        $this->assertTrue($response instanceof UserEmailVerificationStartResponseObject);
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

        $this->assertTrue($response instanceof UserEmailVerificationFinishResponseObject);
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

        $this->assertTrue($response instanceof  UserPhoneVerificationStartResponseObject);
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

        $this->assertTrue($response instanceof UserPhoneVerificationFinishResponseObject);
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

        $this->assertTrue($response instanceof UserSmsVerificationStartResponseObject);
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

        $this->assertTrue($response instanceof UserSmsVerificationFinishResponseObject);
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

        $this->assertTrue($response instanceof UserFireEventResponseObject);
    }

    /**
     * @param BillingMethodObject|null $billingMethod
     * @param BillingMethodObject|null $testBillingMethod
     *
     * @return $this
     */
    private function compareBillingMethod(
        BillingMethodObject $billingMethod = null,
        BillingMethodObject $testBillingMethod = null
    ) {
        if ($this->compareNonObject($billingMethod, $testBillingMethod, BillingMethodObject::class)) {
            return $this;
        }

        $this->assertEquals($billingMethod->getBillingMethodId(), $testBillingMethod->getBillingMethodId());
        $this->assertEquals($billingMethod->getName(), $testBillingMethod->getName());
        $this->assertEquals($billingMethod->getDisplayName(), $testBillingMethod->getDisplayName());
        $this->assertEquals($billingMethod->isAvailable(), $testBillingMethod->isAvailable());
        $this->assertEquals($billingMethod->isCheckout(), $testBillingMethod->isCheckout());
        $this->assertEquals($billingMethod->isFlexible(), $testBillingMethod->isFlexible());
        $this->assertEquals($billingMethod->isRecurring(), $testBillingMethod->isRecurring());
        $this->assertEquals($billingMethod->isReplaceable(), $testBillingMethod->isReplaceable());

        return $this;
    }

    /**
     * @param FlexibleObject|null $flexible
     * @param FlexibleObject|null $testFlexible
     *
     * @return $this
     */
    private function compareFlexible(
        FlexibleObject $flexible = null,
        FlexibleObject $testFlexible = null
    ) {
        if ($this->compareNonObject($flexible, $testFlexible, FlexibleObject::class)) {
            return $this;
        }

        $this->assertEquals($flexible->getFlexibleId(), $testFlexible->getFlexibleId());
        $this->assertEquals($flexible->getStatus(), $testFlexible->getStatus());
        $this->assertEmpty(\array_diff($flexible->getMetaData(), $testFlexible->getMetaData()));
        $this->assertEquals($flexible->getCreatedAt(), $testFlexible->getCreatedAt());
        $this->assertEquals($flexible->getBillingMethod(), $testFlexible->getBillingMethod());
        $this->compareBillingMethod($flexible->getBillingMethodObject(), $testFlexible->getBillingMethodObject());

        return $this;
    }

    /**
     * @param BillingEventObject|null $billingEvent
     * @param BillingEventObject|null $testBillingEvent
     *
     * @return $this
     */
    private function compareBillingEvent(
        BillingEventObject $billingEvent = null,
        BillingEventObject $testBillingEvent = null
    ) {
        if ($this->compareNonObject($billingEvent, $testBillingEvent, BillingEventObject::class)) {
            return $this;
        }

        $this->assertEquals($billingEvent->getBillingEventId(), $testBillingEvent->getBillingEventId());
        $this->assertEquals($billingEvent->getUserId(), $testBillingEvent->getUserId());
        $this->assertEquals($billingEvent->getCurrencyCode(), $testBillingEvent->getCurrencyCode());
        $this->assertEquals($billingEvent->getCreatedAt(), $testBillingEvent->getCreatedAt());
        $this->assertEquals($billingEvent->getType(), $testBillingEvent->getType());
        $this->assertEquals($billingEvent->getStatus(), $testBillingEvent->getStatus());
        $this->assertEquals($billingEvent->getDescription(), $testBillingEvent->getDescription());
        $this->assertEquals($billingEvent->getTechinfo(), $testBillingEvent->getTechinfo());
        $this->assertEquals($billingEvent->getBillingMethod(), $testBillingEvent->getBillingMethod());
        $this->compareSubscription($billingEvent->getSubscription(), $testBillingEvent->getSubscription());
        $this->assertEquals($billingEvent->getModifiedAt(), $testBillingEvent->getModifiedAt());
        $this->compareBillingMethod($billingEvent->getBillingMethodObject(), $testBillingEvent->getBillingMethodObject());

        return $this;
    }

    /**
     * @param SubscriptionObject|null $subscription
     * @param SubscriptionObject|null $testSubscription
     *
     * @return $this
     */
    private function compareSubscription(
        SubscriptionObject $subscription = null,
        SubscriptionObject $testSubscription = null
    ) {
        if ($this->compareNonObject($subscription, $testSubscription, SubscriptionObject::class)) {
            return $this;
        }

        $this->assertEquals($subscription->getSubscriptionId(), $testSubscription->getSubscriptionId());
        $this->comparePackage($subscription->getCurrentPackage(), $testSubscription->getCurrentPackage());
        $this->assertEquals($subscription->getUserId(), $testSubscription->getUserId());
        $this->assertEquals($subscription->getStatus(), $testSubscription->getStatus());
        $this->assertEquals($subscription->getStartedAt(), $testSubscription->getStartedAt());
        $this->assertEquals($subscription->getCanceledAt(), $testSubscription->getCanceledAt());
        $this->assertEquals($subscription->getClosedAt(), $testSubscription->getClosedAt());
        $this->assertEquals($subscription->getExpiresAt(), $testSubscription->getExpiresAt());
        $this->assertEquals($subscription->getNextBillingAt(), $testSubscription->getNextBillingAt());
        $this->assertEquals($subscription->isInitialPeriod(), $testSubscription->isInitialPeriod());
        $this->assertEquals($subscription->isProvisioned(), $testSubscription->isProvisioned());
        $this->assertEmpty(\array_diff($subscription->getProvisioningMetaData(), $testSubscription->getProvisioningMetaData()));
        $this->compareNextPackage($subscription->getNextPackage(), $testSubscription->getNextPackage());

        $testAddonSubscriptions = $testSubscription->getAddonSubscriptions();

        $this->assertEquals(\count($subscription->getAddonSubscriptions()), \count($testAddonSubscriptions));

        foreach ($subscription->getAddonSubscriptions() as $addonSubscription) {
            if (!isset($testAddonSubscriptions[$addonSubscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($addonSubscription, $testAddonSubscriptions[$addonSubscription->getSubscriptionId()]);
        }

        $this->assertEquals($subscription->getMinimumTermEndsAt(), $testSubscription->getMinimumTermEndsAt());
        $this->assertEquals($subscription->isExternal(), $testSubscription->isExternal());
        $this->compareCouponUsage($subscription->getCouponUsage(), $testSubscription->getCouponUsage());
        $this->comparePeriodEvent($subscription->getCurrentPeriodEvent(), $testSubscription->getCurrentPeriodEvent());
        $this->assertEquals($subscription->getNextBillingAmount(), $testSubscription->getNextBillingAmount());

        return $this;
    }

    /**
     * @param PackageObject|null $package
     * @param PackageObject|null $testPackage
     *
     * @return $this
     */
    private function comparePackage(PackageObject $package = null, PackageObject $testPackage = null) {
        if ($this->compareNonObject($package, $testPackage, PackageObject::class)) {
            return $this;
        }

        $this->assertEquals($package->getPackageIdentifier(), $testPackage->getPackageIdentifier());
        $this->assertEquals($package->getServiceIdentifier(), $testPackage->getServiceIdentifier());
        $this->assertEquals($package->getServiceIdentifier(), $testPackage->getServiceIdentifier());

        $testDisplayNames = $testPackage->getDisplayNames();

        $this->assertEquals(\count($package->getDisplayNames()), \count($testDisplayNames));

        foreach ($package->getDisplayNames() as $displayName) {
            if (!isset($testDisplayNames[$displayName->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($displayName, $testDisplayNames[$displayName->getName()]);
        }

        $this->assertEquals($package->isSignupAvailable(), $testPackage->isSignupAvailable());

        $testAddonPackages = $testPackage->getAddonPackages();

        $this->assertEquals(\count($package->getAddonPackages()), \count($testAddonPackages));

        foreach ($package->getAddonPackages() as $addonPackage) {
            if (!isset($testAddonPackages[$addonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($addonPackage, $testAddonPackages[$addonPackage->getPackageIdentifier()]);
        }

        $this->assertEmpty(\array_diff($package->getMetaData(), $testPackage->getMetaData()));
        $this->comparePackagePeriod($package->getInitialPeriod(), $testPackage->getInitialPeriod());
        $this->comparePackagePeriod($package->getRecurringPeriod(), $testPackage->getRecurringPeriod());
        $this->assertEquals($package->hasTrialPeriod(), $testPackage->hasTrialPeriod());

        $testBillingMethods = $testPackage->getBillingMethods();

        $this->assertEquals(\count($package->getBillingMethods()), \count($testBillingMethods));

        foreach ($package->getBillingMethods() as $billingMethod) {
            if (!isset($testBillingMethods[$billingMethod->getBillingMethodId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($billingMethod, $testBillingMethods[$billingMethod->getBillingMethodId()]);
        }

        $this->assertEquals($package->requiresFlexibleForFreeSignup(), $testPackage->requiresFlexibleForFreeSignup());

        return $this;
    }

    /**
     * @param NextPackageObject|null $nextPackage
     * @param NextPackageObject|null $testNextPackage
     *
     * @return $this
     */
    private function compareNextPackage(
        NextPackageObject $nextPackage = null,
        NextPackageObject $testNextPackage = null
    ) {
        if ($this->compareNonObject($nextPackage, $testNextPackage, NextPackageObject::class)) {
            return $this;
        }

        $this->assertEquals($nextPackage->getPackageIdentifier(), $testNextPackage->getPackageIdentifier());
        $this->assertEquals($nextPackage->getServiceIdentifier(), $testNextPackage->getServiceIdentifier());
        $this->assertEquals($nextPackage->getServiceIdentifier(), $testNextPackage->getServiceIdentifier());

        $testDisplayNames = $testNextPackage->getDisplayNames();

        $this->assertEquals(\count($nextPackage->getDisplayNames()), \count($testDisplayNames));

        foreach ($nextPackage->getDisplayNames() as $displayName) {
            if (!isset($testDisplayNames[$displayName->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($displayName, $testDisplayNames[$displayName->getName()]);
        }

        $testAddonPackages = $testNextPackage->getAddonPackages();

        $this->assertEquals($nextPackage->isSignupAvailable(), $testNextPackage->isSignupAvailable());

        foreach ($nextPackage->getAddonPackages() as $addonPackage) {
            if (!isset($testAddonPackages[$addonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($addonPackage, $testAddonPackages[$addonPackage->getPackageIdentifier()]);
        }

        $this->assertEmpty(\array_diff($nextPackage->getMetaData(), $testNextPackage->getMetaData()));

        $this->comparePackagePeriod($nextPackage->getInitialPeriod(), $testNextPackage->getInitialPeriod());
        $this->comparePackagePeriod($nextPackage->getRecurringPeriod(), $testNextPackage->getRecurringPeriod());
        $this->assertEquals($nextPackage->isPaid(), $testNextPackage->isPaid());
        $this->assertEquals($nextPackage->getEffectiveAt(), $testNextPackage->getEffectiveAt());

        return $this;
    }

    /**
     * @param PackagePeriodObject|null $packagePeriod
     * @param PackagePeriodObject|null $testPackagePeriod
     *
     * @return $this
     */
    private function comparePackagePeriod(
        PackagePeriodObject $packagePeriod = null,
        PackagePeriodObject $testPackagePeriod = null
    ) {
        if (!(($packagePeriod instanceof PackagePeriodObject) && ($testPackagePeriod instanceof PackagePeriodObject))) {
            $this->assertTrue($packagePeriod === $testPackagePeriod);

            return $this;
        }

        $this->assertTrue($packagePeriod->getLength() === $testPackagePeriod->getLength());
        $this->assertTrue($packagePeriod->getLengthUnit() === $testPackagePeriod->getLengthUnit());
        $this->assertEmpty(\array_diff($packagePeriod->getMetaData(), $testPackagePeriod->getMetaData()));

        $testPrices = $testPackagePeriod->getBasePrice();
        foreach ($packagePeriod->getBasePrice() as $price) {
            if (!isset($testPrices[$price->getTag()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($price, $testPrices[$price->getTag()]);
        }

        $this->assertTrue($packagePeriod->getMinimumTermLength() === $testPackagePeriod->getMinimumTermLength());

        return $this;
    }

    /**
     * @param PriceObject|null $price
     * @param PriceObject|null $testPrice
     *
     * @return $this
     */
    private function comparePrice(PriceObject $price = null, PriceObject $testPrice = null) {
        if (!(($price instanceof PriceObject) && ($testPrice instanceof PriceObject))) {
            $this->assertTrue($price === $testPrice);

            return $this;
        }

        $this->assertTrue($price->getAmount() === $testPrice->getAmount());
        $this->assertTrue($price->getCurrencyCode() === $testPrice->getCurrencyCode());
        $this->assertTrue($price->getGroup() === $testPrice->getGroup());
        $this->assertTrue($price->getTag() === $testPrice->getTag());

        $testCompositePrices = $testPrice->getCompositePrices();
        foreach ($price->getCompositePrices() as $compositePrice) {
            if (!isset($testCompositePrices[$compositePrice->getTag()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($compositePrice, $testCompositePrices[$compositePrice->getTag()]);
        }

        return $this;
    }

    /**
     * @param CouponUsageObject|null $couponUsage
     * @param CouponUsageObject|null $testCouponUsage
     *
     * @return $this
     */
    private function compareCouponUsage(
        CouponUsageObject $couponUsage = null,
        CouponUsageObject $testCouponUsage = null
    ) {
        if (!(($couponUsage instanceof CouponUsageObject) && ($testCouponUsage instanceof CouponUsageObject))) {
            $this->assertTrue($couponUsage === $testCouponUsage);

            return $this;
        }

        $this->compareCoupon($couponUsage->getCoupon(), $testCouponUsage->getCoupon());
        $this->assertTrue($couponUsage->getNumPeriods() === $testCouponUsage->getNumPeriods());
        $this->compareDateTime($couponUsage->getCreatedAt(), $testCouponUsage->getCreatedAt());
        $this->compareDateTime($couponUsage->getModifiedAt(), $testCouponUsage->getModifiedAt());

        return $this;
    }

    /**
     * @param CouponObject|null $coupon
     * @param CouponObject|null $testCoupon
     *
     * @return $this
     */
    private function compareCoupon(CouponObject $coupon = null, CouponObject $testCoupon = null) {
        if (!(($coupon instanceof CouponObject) && ($testCoupon instanceof CouponObject))) {
            $this->assertTrue($coupon === $testCoupon);

            return $this;
        }

        $this->assertTrue($coupon->getCode() === $testCoupon->getCode());
        $this->assertTrue($coupon->getDescription() === $testCoupon->getDescription());

        return $this;
    }

    /**
     * @param PeriodEventObject|null $periodEvent
     * @param PeriodEventObject|null $testPeriodEvent
     *
     * @return $this
     */
    private function comparePeriodEvent(
        PeriodEventObject $periodEvent = null,
        PeriodEventObject $testPeriodEvent = null
    ) {
        if (!(($periodEvent instanceof PeriodEventObject) && ($testPeriodEvent instanceof PeriodEventObject))) {
            $this->assertTrue($periodEvent === $testPeriodEvent);

            return $this;
        }

        $this->assertTrue($periodEvent->getPeriodEventId() === $testPeriodEvent->getPeriodEventId());
        $this->assertTrue($periodEvent->getPeriodId() === $testPeriodEvent->getPeriodId());
        $this->assertTrue($periodEvent->getSubscriptionHistoryId() === $testPeriodEvent->getSubscriptionHistoryId());
        $this->compareDateTime($periodEvent->getStartedAt(), $testPeriodEvent->getStartedAt());
        $this->compareDateTime($periodEvent->getEndsAt(), $testPeriodEvent->getEndsAt());
        $this->assertTrue($periodEvent->getParentPeriodEventId() === $testPeriodEvent->getParentPeriodEventId());
        $this->compareDateTime($periodEvent->getOriginalEndsAt(), $testPeriodEvent->getOriginalEndsAt());

        return $this;
    }

    /**
     * @param DisplayNameObject|null $displayName
     * @param DisplayNameObject|null $testDisplayName
     *
     * @return $this
     */
    private function compareDisplayName(
        DisplayNameObject $displayName = null,
        DisplayNameObject $testDisplayName = null
    ) {
        if (!(($displayName instanceof DisplayNameObject) && ($testDisplayName instanceof DisplayNameObject))) {
            $this->assertTrue($displayName === $testDisplayName);

            return $this;
        }

        $this->assertTrue($displayName->getLanguage() === $testDisplayName->getLanguage());
        $this->assertTrue($displayName->getName() === $testDisplayName->getName());

        return $this;
    }

    /**
     * @param ExternalProfileObject|null $externalProfile
     * @param ExternalProfileObject|null $testExternalProfile
     *
     * @return $this
     */
    private function compareExternalProfile(
        ExternalProfileObject $externalProfile = null,
        ExternalProfileObject $testExternalProfile = null
    ) {
        if (!(($externalProfile instanceof ExternalProfileObject) && ($testExternalProfile instanceof ExternalProfileObject))) {
            $this->assertTrue($externalProfile === $testExternalProfile);

            return $this;
        }

        $this->assertTrue($externalProfile->getUserId() === $testExternalProfile->getUserId());
        $this->assertTrue($externalProfile->getSubscriptionId() === $testExternalProfile->getSubscriptionId());
        $this->assertEmpty(\array_diff($externalProfile->getExtraData(), $testExternalProfile->getExtraData()));
        $this->assertTrue($externalProfile->getExternalId() === $testExternalProfile->getExternalId());

        return $this;
    }

    /**
     * @param RecurringObject|null $recurring
     * @param RecurringObject|null $testRecurring
     *
     * @return $this
     */
    private function compareRecurring(RecurringObject $recurring = null, RecurringObject $testRecurring = null) {
        if ($this->compareNonObject($recurring, $testRecurring, RecurringObject::class)) {
            return $this;
        }

        $this->assertTrue($recurring->getRecurringId() === $testRecurring->getRecurringId());
        $this->assertTrue($recurring->getStatus() === $testRecurring->getStatus());
        $this->assertTrue($recurring->getProviderToken() === $testRecurring->getProviderToken());
        $this->compareDateTime($recurring->getCreatedAt(), $testRecurring->getCreatedAt());
        $this->compareDateTime($recurring->getCanceledAt(), $testRecurring->getCanceledAt());
        $this->compareDateTime($recurring->getClosedAt(), $testRecurring->getClosedAt());
        $this->assertEmpty(\array_diff($recurring->getParameters(), $testRecurring->getParameters()));
        $this->assertTrue($recurring->getAmount() === $testRecurring->getAmount());
        $this->assertTrue($recurring->getCurrency() === $testRecurring->getCurrency());

        return $this;
    }

    /**
     * @param UserObject|null $user
     * @param UserObject|null $testUser
     *
     * @return $this
     */
    private function compareUser(UserObject $user = null, UserObject $testUser = null) {
        if ($this->compareNonObject($user, $testUser, UserObject::class)) {
            return $this;
        }

        $this->assertEquals($user->getUserId(), $testUser->getUserId());
        $this->compareDateTime($user->getCreatedAt(), $testUser->getCreatedAt());
        $this->assertEquals($user->isLoginDisabled(), $testUser->isLoginDisabled());
        $this->assertEquals($user->getLanguage(), $testUser->getLanguage());
        $this->compareDateTime($user->getLastLoginDate(), $testUser->getLastLoginDate());
        $this->assertEquals($user->getLastLoginIp(), $testUser->getLastLoginIp());
        $this->assertEmpty(\array_diff($user->getMetaData(), $testUser->getMetaData()));
        $this->assertEquals($user->getCurrencyCode(), $testUser->getCurrencyCode());
        $this->assertEmpty(\array_diff($user->getVerifiedData(), $testUser->getVerifiedData()));
        $this->compareAuthToken($user->getAuthToken(), $testUser->getAuthToken());

        return $this;
    }

    /**
     * @param AuthTokenObject|null $authToken
     * @param AuthTokenObject|null $testAuthToken
     *
     * @return $this
     */
    private function compareAuthToken(AuthTokenObject $authToken = null, AuthTokenObject $testAuthToken = null) {
        if ($this->compareNonObject($authToken, $testAuthToken, AuthTokenObject::class)) {
            return $this;
        }

        $this->assertEquals($authToken->getId(), $testAuthToken->getId());
        $this->assertEquals($authToken->getUserId(), $testAuthToken->getUserId());
        $this->assertEquals($authToken->getToken(), $testAuthToken->getToken());
        $this->compareDateTime($authToken->getCreatedAt(), $testAuthToken->getCreatedAt());
        $this->compareDateTime($authToken->getModifiedAt(), $testAuthToken->getModifiedAt());
        $this->compareDateTime($authToken->getValidUntil(), $testAuthToken->getValidUntil());
        $this->assertEquals($authToken->getMetaInfo(), $testAuthToken->getMetaInfo());

        return $this;
    }

    /**
     * @param MetaProfileElementObject|null $metaProfileElement
     * @param MetaProfileElementObject|null $testMetaProfileElement
     *
     * @return $this
     */
    public function compareMetaProfileElement(
        MetaProfileElementObject $metaProfileElement = null,
        MetaProfileElementObject $testMetaProfileElement = null
    ) {
        if (
            $this->compareNonObject($metaProfileElement, $testMetaProfileElement, MetaProfileElementObject::class)
        ) {
            return $this;
        }

        $this->assertEquals($metaProfileElement->getName(), $testMetaProfileElement->getName());
        $this->assertEquals($metaProfileElement->isRequired(), $testMetaProfileElement->isRequired());
        $this->assertEquals($metaProfileElement->isUnique(), $testMetaProfileElement->isUnique());

        return $this;
    }

    /**
     * @param mixed  $response
     * @param mixed  $testResponse
     * @param string $class
     *
     * @return bool
     */
    private function compareNonObject($response, $testResponse, $class) {
        if (!(($response instanceof $class) && ($testResponse instanceof $class))) {
            $this->assertTrue($response === $testResponse);

            return true;
        }

        return false;
    }

    /**
     * @param DateTime|null $dateTime
     * @param DateTime|null $testDateTime
     *
     * @return $this
     */
    private function compareDateTime(\DateTime $dateTime = null, \DateTime $testDateTime = null) {
        if (($dateTime instanceof \DateTime) && ($testDateTime instanceof \DateTime)) {
            $this->assertTrue($dateTime->format('U') === $testDateTime->format('U'));

            return $this;
        }

        $this->assertTrue($dateTime === $testDateTime);

        return $this;
    }

    /**
     * @param string $methodName
     *
     * @return ReflectionMethod
     */
    private function getAccessibleMethod($methodName) {
        $frontendClientClass = new ReflectionClass(FrontendClient::class);

        $method = $frontendClientClass->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @param array|TestResponseInterface $response
     * @param bool                        $forceTokenMode
     *
     * @return FrontendClient
     */
    private function createFrontendClient($response = [], $forceTokenMode = true) {
        return new FrontendClient(
            $this->createTestRequestClient($response),
            $forceTokenMode
        );
    }

    /**
     * @param  array|TestResponseInterface $response
     *
     * @return TestRequestClient
     */
    private function createTestRequestClient($response) {
        return new TestRequestClient($response);
    }

}