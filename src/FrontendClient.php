<?php

namespace Ixolit\Dislo;


use Ixolit\Dislo\Exceptions\AuthenticationException;
use Ixolit\Dislo\Exceptions\AuthenticationInvalidCredentialsException;
use Ixolit\Dislo\Exceptions\AuthenticationRateLimitedException;
use Ixolit\Dislo\Exceptions\DisloException;
use Ixolit\Dislo\Exceptions\InvalidTokenException;
use Ixolit\Dislo\Exceptions\NotImplementedException;
use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\Request\RequestClient;
use Ixolit\Dislo\Request\RequestClientExtra;
use Ixolit\Dislo\Response\BillingCloseActiveRecurringResponseObject;
use Ixolit\Dislo\Response\BillingCloseFlexibleResponseObject;
use Ixolit\Dislo\Response\BillingCreateFlexibleResponseObject;
use Ixolit\Dislo\Response\BillingCreatePaymentResponseObject;
use Ixolit\Dislo\Response\BillingExternalCreateChargebackByEventIdResponseObject;
use Ixolit\Dislo\Response\BillingExternalCreateChargebackByTransactionIdResponseObject;
use Ixolit\Dislo\Response\BillingExternalCreateChargeResponseObject;
use Ixolit\Dislo\Response\BillingExternalGetProfileByExternalIdResponseObject;
use Ixolit\Dislo\Response\BillingExternalGetProfileBySubscriptionIdResponseObject;
use Ixolit\Dislo\Response\BillingGetActiveRecurringResponseObject;
use Ixolit\Dislo\Response\BillingGetEventResponseObject;
use Ixolit\Dislo\Response\BillingGetEventsForUserResponseObject;
use Ixolit\Dislo\Response\BillingGetFlexibleByIdentifierResponseObject;
use Ixolit\Dislo\Response\BillingGetFlexibleResponseObject;
use Ixolit\Dislo\Response\BillingMethodsGetAvailableResponseObject;
use Ixolit\Dislo\Response\BillingMethodsGetResponseObject;
use Ixolit\Dislo\Response\CouponCodeCheckResponseObject;
use Ixolit\Dislo\Response\CouponCodeValidateNewResponseObject;
use Ixolit\Dislo\Response\CouponCodeValidateUpgradeResponseObject;
use Ixolit\Dislo\Response\MiscGetRedirectorConfigurationResponseObject;
use Ixolit\Dislo\Response\PackageGetResponseObject;
use Ixolit\Dislo\Response\PackagesListResponseObject;
use Ixolit\Dislo\Response\SubscriptionCalculateAddonPriceResponseObject;
use Ixolit\Dislo\Response\SubscriptionCalculatePackageChangeResponseObject;
use Ixolit\Dislo\Response\SubscriptionCalculatePriceResponseObject;
use Ixolit\Dislo\Response\SubscriptionCallSpiResponseObject;
use Ixolit\Dislo\Response\SubscriptionCancelPackageChangeResponseObject;
use Ixolit\Dislo\Response\SubscriptionCancelResponseObject;
use Ixolit\Dislo\Response\SubscriptionChangeResponseObject;
use Ixolit\Dislo\Response\SubscriptionCloseResponseObject;
use Ixolit\Dislo\Response\SubscriptionContinueResponseObject;
use Ixolit\Dislo\Response\SubscriptionCreateAddonResponseObject;
use Ixolit\Dislo\Response\SubscriptionCreateResponseObject;
use Ixolit\Dislo\Response\SubscriptionExternalAddonCreateResponseObject;
use Ixolit\Dislo\Response\SubscriptionExternalChangePeriodResponseObject;
use Ixolit\Dislo\Response\SubscriptionExternalChangeResponseObject;
use Ixolit\Dislo\Response\SubscriptionExternalCloseResponseObject;
use Ixolit\Dislo\Response\SubscriptionExternalCreateResponseObject;
use Ixolit\Dislo\Response\SubscriptionGetAllResponseObject;
use Ixolit\Dislo\Response\SubscriptionGetPeriodEventsResponseObject;
use Ixolit\Dislo\Response\SubscriptionGetPossiblePackageChangesResponseObject;
use Ixolit\Dislo\Response\SubscriptionGetResponseObject;
use Ixolit\Dislo\Response\UserAuthenticateResponseObject;
use Ixolit\Dislo\Response\UserChangePasswordResponseObject;
use Ixolit\Dislo\Response\UserChangeResponseObject;
use Ixolit\Dislo\Response\UserCreateResponseObject;
use Ixolit\Dislo\Response\UserDeauthenticateResponseObject;
use Ixolit\Dislo\Response\UserDeleteResponseObject;
use Ixolit\Dislo\Response\UserDisableLoginResponseObject;
use Ixolit\Dislo\Response\UserEnableLoginResponseObject;
use Ixolit\Dislo\Response\UserExtendTokenResponseObject;
use Ixolit\Dislo\Response\UserFindResponseObject;
use Ixolit\Dislo\Response\UserGetAuthenticatedResponseObject;
use Ixolit\Dislo\Response\UserGetBalanceResponseObject;
use Ixolit\Dislo\Response\UserGetMetaProfileResponseObject;
use Ixolit\Dislo\Response\UserGetResponseObject;
use Ixolit\Dislo\Response\UserGetTokensResponseObject;
use Ixolit\Dislo\Response\UserPhoneVerificationFinishResponseObject;
use Ixolit\Dislo\Response\UserPhoneVerificationStartResponseObject;
use Ixolit\Dislo\Response\UserRecoveryCheckResponseObject;
use Ixolit\Dislo\Response\UserRecoveryFinishResponseObject;
use Ixolit\Dislo\Response\UserRecoveryStartResponseObject;
use Ixolit\Dislo\Response\UserSmsVerificationFinishResponseObject;
use Ixolit\Dislo\Response\UserSmsVerificationStartResponseObject;
use Ixolit\Dislo\Response\UserUpdateTokenResponseObject;
use Ixolit\Dislo\Response\UserEmailVerificationFinishResponseObject;
use Ixolit\Dislo\Response\UserEmailVerificationStartResponseObject;
use Ixolit\Dislo\WorkingObjects\AuthTokenObject;
use Ixolit\Dislo\WorkingObjects\BillingEventObject;
use Ixolit\Dislo\WorkingObjects\FlexibleObject;
use Ixolit\Dislo\WorkingObjects\SubscriptionObject;
use Ixolit\Dislo\WorkingObjects\UserObject;
use Psr\Http\Message\StreamInterface;

/**
 * Class FrontendClient
 *
 * Client class for the Dislo Frontend API.
 *
 * @package Ixolit\Dislo
 */
final class FrontendClient {

    //region Frontend API URIs

    const API_URI_BILLING_METHODS_GET = '/frontend/billing/getPaymentMethods';
    const API_URI_BILLING_METHODS_GET_FOR_PACKAGE = '/frontend/billing/getPaymentMethodsForPackage';
    const API_URI_BILLING_CLOSE_FLEXIBLE = '/frontend/billing/closeFlexible';
    const API_URI_BILLING_CREATE_FLEXIBLE = '/frontend/billing/createFlexible';
    const API_URI_BILLING_CREATE_PAYMENT = '/frontend/billing/createPayment';
    const API_URI_BILLING_EXTERNAL_CREATE_CHARGE = '/frontend/billing/externalCreateCharge';
    const API_URI_BILLING_EXTERNAL_CREATE_CHARGEBACK = '/frontend/billing/externalCreateChargeback';
    const API_URI_BILLING_EXTERNAL_GET_PROFILE = '/frontend/billing/externalGetProfile';
    const API_URI_BILLING_GET_EVENT = '/frontend/billing/getBillingEvent';
    const API_URI_BILLING_GET_EVENTS_FOR_USER = '/frontend/billing/getBillingEventsForUser';
    const API_URI_BILLING_GET_FLEXIBLE = '/frontend/billing/getFlexible';
    const API_URI_BILLING_GET_FLEXIBLE_BY_ID = '/frontend/billing/getFlexibleById';
    const API_URI_BILLING_GET_ACTIVE_RECURRING = '/frontend/billing/getActiveRecurring';
    const API_URI_BILLING_CLOSE_ACTIVE_RECURRING = '/frontend/billing/closeActiveRecurring';

    const API_URI_SUBSCRIPTION_CALCULATE_ADDON_PRICE = '/frontend/subscription/calculateAddonPrice';
    const API_URI_SUBSCRIPTION_CALCULATE_PACKAGE_CHANGE = '/frontend/subscription/calculatePackageChange';
    const API_URI_SUBSCRIPTION_CALCULATE_PRICE = '/frontend/subscription/calculateSubscriptionPrice';
    const API_URI_SUBSCRIPTION_CANCEL_PACKAGE_CHANGE = '/frontend/subscription/cancelPackageChange';
    const API_URI_SUBSCRIPTION_CANCEL = '/frontend/subscription/cancel';
    const API_URI_SUBSCRIPTION_CHANGE = '/frontend/subscription/changePackage';
    const API_URI_COUPON_CODE_CHECK = '/frontend/subscription/checkCouponCode';
    const API_URI_SUBSCRIPTION_CLOSE = '/frontend/subscription/close';
    const API_URI_SUBSCRIPTION_CONTINUE = '/frontend/subscription/continue';
    const API_URI_SUBSCRIPTION_CREATE_ADDON = '/frontend/subscription/createAddonSubscription';
    const API_URI_SUBSCRIPTION_CREATE = '/frontend/subscription/create';
    const API_URI_SUBSCRIPTION_EXTERNAL_CHANGE = '/frontend/subscription/externalChangePackage';
    const API_URI_SUBSCRIPTION_EXTERNAL_CHANGE_PERIOD = '/frontend/subscription/externalChangePeriod';
    const API_URI_SUBSCRIPTION_EXTERNAL_CLOSE = '/frontend/subscription/externalCloseSubscription';
    const API_URI_SUBSCRIPTION_EXTERNAL_CREATE_ADDON_SUBSCRIPTION = '/frontend/subscription/externalCreateAddonSubscription';
    const API_URI_SUBSCRIPTION_EXTERNAL_CREATE = '/frontend/subscription/externalCreateSubscription';
    const API_URI_SUBSCRIPTION_CALL_SPI = '/frontend/subscription/callSpi';
    const API_URI_SUBSCRIPTION_GET_POSSIBLE_PACKAGE_CHANGES = '/frontend/subscription/getPossiblePackageChanges';
    const API_URI_PACKAGE_LIST = '/frontend/subscription/getPackages';
    const API_URI_SUBSCRIPTION_GET = '/frontend/subscription/get';
    const API_URI_SUBSCRIPTION_GET_ALL = '/frontend/subscription/getSubscriptions';
    const API_URI_SUBSCRIPTION_GET_PERIOD_EVENTS = '/frontend/subscription/getPeriodHistory';
    const API_URI_COUPON_CODE_VALIDATE = '/frontend/subscription/validateCoupon';

    const API_URI_USER_AUTHENTICATE = '/frontend/user/authenticate';
    const API_URI_USER_DEAUTHENTICATE = '/frontend/user/deAuthToken';
    const API_URI_USER_CHANGE = '/frontend/user/change';
    const API_URI_USER_CHANGE_PASSWORD = '/frontend/user/changePassword';
    const API_URI_USER_CREATE = '/frontend/user/create';
    const API_URI_USER_DELETE = '/frontend/user/delete';
    const API_URI_USER_DISABLE_LOGIN = '/frontend/user/disableLogin';
    const API_URI_USER_ENABLE_LOGIN = '/frontend/user/enableLogin';
    const API_URI_USER_GET_ACCOUNT_BALANCE = '/frontend/user/getBalance';
    const API_URI_USER_GET_META_PROFILE = '/frontend/user/getMetaProfile';
    const API_URI_USER_GET_AUTH_TOKENS = '/frontend/user/getTokens';
    const API_URI_USER_GET = '/frontend/user/get';
    const API_URI_USER_UPDATE_AUTH_TOKEN = '/frontend/user/updateToken';
    const API_URI_USER_EXTEND_AUTH_TOKEN = '/frontend/user/extendTokenLifeTime';
    const API_URI_USER_GET_AUTHENTICATED = '/frontend/user/getAuthenticated';
    const API_URI_USER_FIND = '/frontend/user/findUser';
    const API_URI_USER_RECOVERY_START = '/frontend/user/passwordRecovery/start';
    const API_URI_USER_RECOVERY_CHECK = '/frontend/user/passwordRecovery/check';
    const API_URI_USER_RECOVERY_FINISH = '/frontend/user/passwordRecovery/finalize';
    const API_URI_USER_VERIFICATION_START = '/frontend/user/verification/start';
    const API_URI_USER_VERIFICATION_FINISH = '/frontend/user/verification/finalize';

    const API_URI_REDIRECTOR_GET_CONFIGURATION = '/frontend/misc/getRedirectorConfiguration';

    const API_URI_EXPORT_STREAM_REPORT = '/export/v2/report/';
    const API_URI_EXPORT_STREAM_QUERY = '/export/v2/query';

    //endregion

    const COUPON_EVENT_START    = 'subscription_start';
    const COUPON_EVENT_UPGRADE  = 'subscription_upgrade';

    const PLAN_CHANGE_IMMEDIATE = 'immediate';
    const PLAN_CHANGE_QUEUED    = 'queued';

    const ORDER_DIR_ASC = 'ASC';
    const ORDER_DIR_DESC = 'DESC';

    /** @var RequestClient */
    private $requestClient;

    /** @var bool */
    private $forceTokenMode;

    /**
     * Initialize the client with a RequestClient, the class that is responsible for transporting messages to and
     * from the Dislo API.
     *
     * @param RequestClient $requestClient
     * @param bool          $forceTokenMode Force using tokens. Does not allow passing a user Id.
     *
     * @throws DisloException if the $requestClient parameter is missing
     */
    public function __construct(RequestClient $requestClient, $forceTokenMode = true) {
        $this->requestClient  = $requestClient;
        $this->forceTokenMode = $forceTokenMode;
    }

    /**
     * @return RequestClientExtra
     *
     * @throws NotImplementedException
     */
    private function getRequestClientExtra() {
        if ($this->requestClient instanceof RequestClientExtra) {
            return $this->requestClient;
        }

        throw new NotImplementedException();
    }

    /**
     * @param RequestClient $requestClient
     *
     * @return $this
     */
    public function setRequestClient(RequestClient $requestClient) {
        $this->requestClient = $requestClient;

        return $this;
    }

    /**
     * @return RequestClient
     */
    private function getRequestClient() {
        return $this->requestClient;
    }

    /**
     * @return bool
     */
    public function isForceTokenMode() {
        return $this->forceTokenMode;
    }

    /**
     * Performs request and handles response.
     *
     * @param string $uri
     * @param array  $data
     *
     * @return array
     *
     * @throws DisloException
     * @throws ObjectNotFoundException
     */
    private function request($uri, array $data = []) {
        try {
            $response = $this->getRequestClient()->request($uri, $data);

            if (isset($response['success']) && $response['success'] === false) {
                switch ($response['errors'][0]['code']) {
                    case 404:
                        throw new ObjectNotFoundException(
                            $response['errors'][0]['message'] . ' while trying to query ' . $uri,
                            $response['errors'][0]['code']);
                    case 9002:
                        throw new InvalidTokenException();
                    default:
                        throw new DisloException(
                            $response['errors'][0]['message'] . ' while trying to query ' . $uri,
                            $response['errors'][0]['code']);
                }
            }

            return $response;
        } catch (ObjectNotFoundException $e) {
            throw $e;
        } catch (DisloException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new DisloException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Sets user identification to request data.
     *
     * @param string|int|UserObject|null $userTokenOrId
     * @param array                      $data
     *
     * @return array
     */
    private function userToData($userTokenOrId, array $data = []) {
        if ($this->forceTokenMode) {
            $data['authToken'] = (string)$userTokenOrId;

            return $data;
        }

        if ($userTokenOrId instanceof UserObject) {
            $data['userId'] = $userTokenOrId->getUserId();

            return $data;
        }

        if (\is_null($userTokenOrId)) {
            return $data;
        }

        if (
            \is_bool($userTokenOrId)
            || \is_float($userTokenOrId)
            || \is_resource($userTokenOrId)
            || \is_array($userTokenOrId)
        ) {
            throw new \InvalidArgumentException('Invalid user specification: ' . \var_export($userTokenOrId, true));
        }

        if (\is_object($userTokenOrId)) {
            if (!\method_exists($userTokenOrId, '__toString')) {
                throw new \InvalidArgumentException('Invalid user specification: ' . \var_export($userTokenOrId, true));
            }

            $userTokenOrId = $userTokenOrId->__toString();
        }

        if (\is_int($userTokenOrId) || \preg_match('/^[0-9]+$/D', $userTokenOrId)) {
            $data['userId'] = (int)$userTokenOrId;

            return $data;
        }

        $data['authToken'] = $userTokenOrId;

        return $data;
    }

    //region Billing API calls

    /**
     * Retrieve the list of billing methods.
     * If $packageIdentifier is set, the list gets filtered by package and country requirements.
     *
     * @param string|null $packageIdentifier
     * @param string|null $countryCode
     *
     * @return BillingMethodsGetResponseObject
     */
    public function billingMethodsGet($packageIdentifier = null, $countryCode = null) {
        if (empty($packageIdentifier)) {
            $response = $this->request(self::API_URI_BILLING_METHODS_GET, []);
        } else {
            $data = [
                'packageIdentifier' => $packageIdentifier,
                'countryCode'       => $countryCode,
            ];

            $response = $this->request(self::API_URI_BILLING_METHODS_GET_FOR_PACKAGE, $data);
        }

        return BillingMethodsGetResponseObject::fromResponse($response);
    }

    /**
     * Retrieve the list of available billing methods.
     * Filter works like for billingMethodsGet function.
     *
     * @param string|null $packageIdentifier
     * @param string|null $countryCode
     *
     * @return BillingMethodsGetAvailableResponseObject
     */
    public function billingMethodsGetAvailable($packageIdentifier = null, $countryCode = null) {
        $availableBillingMethods = [];
        foreach ($this->billingMethodsGet($packageIdentifier, $countryCode)->getBillingMethods() as $billingMethod) {
            if ($billingMethod->isAvailable()) {
                $availableBillingMethods[] = $billingMethod;
            }
        }

        return new BillingMethodsGetAvailableResponseObject($availableBillingMethods);
    }

    /**
     * Closes the flexible payment method for a user.
     *
     * Note: once you close an active flexible, subscriptions cannot get extended automatically!
     *
     * @see https://docs.dislo.com/display/DIS/CloseFlexible
     *
     * @param FlexibleObject|int    $flexible
     * @param UserObject|int|string $userTokenOrId User authentication token or user ID.
     *
     * @return BillingCloseFlexibleResponseObject
     *
     * @throws DisloException
     */
    public function billingCloseFlexible($flexible, $userTokenOrId) {
        $data = $this->userToData($userTokenOrId, [
            'flexibleId' => ($flexible instanceof FlexibleObject)
                ? $flexible->getFlexibleId()
                : (int)$flexible
        ]);

        $response = $this->request(self::API_URI_BILLING_CLOSE_FLEXIBLE, $data);

        return BillingCloseFlexibleResponseObject::fromResponse($response);
    }

    /**
     * Create a new flexible for a user.
     *
     * Note: there can only be ONE active flexible per user. In case there is already an active one, and you
     * successfully create a new one, the old flexible will be closed automatically.
     *
     * @see https://docs.dislo.com/display/DIS/CreateFlexible
     *
     * @param UserObject|int|string $userTokenOrId User authentication token or user ID.
     * @param string                $billingMethod
     * @param string                $returnUrl
     * @param array                 $paymentDetails
     * @param string                $currencyCode
     *
     * @param null                  $subscriptionId
     *
     * @return BillingCreateFlexibleResponseObject
     */
    public function billingCreateFlexible(
        $userTokenOrId,
        $billingMethod,
        $returnUrl,
        $paymentDetails,
        $currencyCode = '',
        $subscriptionId = null
    ) {
        $data = $this->userToData($userTokenOrId, [
            'billingMethod'  => $billingMethod,
            'returnUrl'      => (string)$returnUrl,
            'paymentDetails' => $paymentDetails,
            'subscriptionId' => $subscriptionId,
        ]);

        if (!empty($currencyCode)) {
            $data['currencyCode'] = $currencyCode;
        }

        $response = $this->request(self::API_URI_BILLING_CREATE_FLEXIBLE, $data);

        return BillingCreateFlexibleResponseObject::fromResponse($response);
    }

    /**
     * Initiate a payment transaction for a new subscription or package change.
     *
     * Only use CreatePayment if you want to create an actual payment for a subscription that needs billing. If you
     * try to create a payment for a subscription that doesn't need one, you will receive the error No subscription
     * or upgrade found for payment. If you just want to register a payment method, use `billingCreateFlexible()`
     * instead.
     *
     * @see https://docs.dislo.com/display/DIS/CreatePayment
     *
     * @param SubscriptionObject|int $subscription
     * @param string                 $billingMethod
     * @param string                 $returnUrl
     * @param array                  $paymentDetails
     * @param UserObject|int|string  $userTokenOrId user authentication token or id
     * @param string|null            $countryCode
     *
     * @return BillingCreatePaymentResponseObject
     */
    public function billingCreatePayment(
        $subscription,
        $billingMethod,
        $returnUrl,
        $paymentDetails,
        $userTokenOrId,
        $countryCode = null
    ) {
        $data = $this->userToData($userTokenOrId, [
            'billingMethod'  => $billingMethod,
            'returnUrl'      => (string)$returnUrl,
            'subscriptionId' => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
            'paymentDetails' => $paymentDetails,
            'countryCode'    => $countryCode,
        ]);

        $response = $this->request(self::API_URI_BILLING_CREATE_PAYMENT, $data);
        if (!$response['redirectUrl']) {
            $response['redirectUrl'] = $returnUrl;
        }

        return BillingCreatePaymentResponseObject::fromResponse($response);
    }

    /**
     * Create an external charge.
     *
     * @see https://docs.dislo.com/display/DIS/ExternalCreateCharge
     * @see https://docs.dislo.com/display/DIS/External+payments+guide
     *
     * @param string               $externalProfileId     the external profile to which the charge should be linked,
     *                                                    this is the "externalId" you passed in the
     *                                                    "subscription/externalCreate" call
     * @param string               $accountIdentifier     the billing account identifier, you will get this from dislo
     * @param string               $currencyCode          currency code EUR, USD, ...
     * @param float                $amount                the amount of the charge
     * @param string               $externalTransactionId external unique id for the charge
     * @param int|null             $packageChangeId       the unique package change  id to which the charge should be linked,
     *                                                    you get this from the "subscription/externalChangePackage" or
     *                                                    "subscription/externalCreateAddonSubscription" call
     * @param array                $paymentDetails        additional data you want to save with the charge
     * @param string               $description           description of the charge
     * @param string               $status                status the charge should be created with, you might want to
     *                                                    log erroneous charges in dislo too, but you don't have to.
     *                                                    @see BillingEvent::STATUS_*
     * @param UserObject|int|string|null $userTokenOrId   User authentication token or user ID.
     *
     * @return BillingExternalCreateChargeResponseObject
     *
     * @throws DisloException
     */
    public function billingExternalCreateCharge(
        $externalProfileId,
        $accountIdentifier,
        $currencyCode,
        $amount,
        $externalTransactionId,
        $packageChangeId = null,
        $paymentDetails = [],
        $description = '',
        $status = BillingEventObject::STATUS_SUCCESS,
        $userTokenOrId = null
    ) {
        $data = $this->userToData($userTokenOrId, [
            'externalProfileId'     => $externalProfileId,
            'accountIdentifier'     => $accountIdentifier,
            'currencyCode'          => $currencyCode,
            'amount'                => $amount,
            'externalTransactionId' => $externalTransactionId,
            'packageChangeId'       => $packageChangeId,
            'paymentDetails'        => $paymentDetails,
            'description'           => $description,
            'status'                => $status,
        ]);

        $response = $this->request(self::API_URI_BILLING_EXTERNAL_CREATE_CHARGE, $data);

        return BillingExternalCreateChargeResponseObject::fromResponse($response);
    }

    /**
     * Create a charge back for an external charge by using the original transaction ID
     *
     * @see https://docs.dislo.com/display/DIS/ExternalCreateChargeback
     * @see https://docs.dislo.com/display/DIS/External+payments+guide
     *
     * @param string                $accountIdentifier     the billing account identifier, assigned by dislo staff
     * @param string                $originalTransactionID external unique id of the original charge
     * @param string                $description           textual description of the chargeback for support
     * @param UserObject|int|string $userTokenOrId         User authentication token or user ID.
     *
     * @return BillingExternalCreateChargebackByTransactionIdResponseObject
     *
     * @throws DisloException
     */
    public function billingExternalCreateChargebackByTransactionId(
        $accountIdentifier,
        $originalTransactionID,
        $description = '',
        $userTokenOrId = null
    ) {
        $data = $this->userToData($userTokenOrId, [
            'accountIdentifier'     => $accountIdentifier,
            'externalTransactionId' => $originalTransactionID,
            'description'           => $description,
        ]);

        $response = $this->request(self::API_URI_BILLING_EXTERNAL_CREATE_CHARGEBACK, $data);

        return BillingExternalCreateChargebackByTransactionIdResponseObject::fromResponse($response);
    }

    /**
     * Create a charge back for an external charge by using the original billing event ID
     *
     * @see https://docs.dislo.com/display/DIS/ExternalCreateChargeback
     * @see https://docs.dislo.com/display/DIS/External+payments+guide
     *
     * @param string                $accountIdentifier      the billing account identifier, assigned by dislo staff
     * @param int                   $originalBillingEventId ID of the original billing event.
     * @param string                $description            textual description of the chargeback for support
     * @param UserObject|int|string $userTokenOrId          User authentication token or user ID.
     *
     * @return BillingExternalCreateChargebackByEventIdResponseObject
     *
     * @throws DisloException
     */
    public function billingExternalCreateChargebackByEventId(
        $accountIdentifier,
        $originalBillingEventId,
        $description = '',
        $userTokenOrId = null
    ) {
        $data = $this->userToData($userTokenOrId, [
            'accountIdentifier' => $accountIdentifier,
            'billingEventId'    => $originalBillingEventId,
            'description'       => $description,
        ]);

        $response = $this->request(self::API_URI_BILLING_EXTERNAL_CREATE_CHARGEBACK, $data);

        return BillingExternalCreateChargebackByEventIdResponseObject::fromResponse($response);
    }

    /**
     * Retrieve an external profile by the external id that has been passed in "subscription/externalCreate".
     *
     * @see https://docs.dislo.com/display/DIS/ExternalGetProfile
     * @see https://docs.dislo.com/display/DIS/External+payments+guide
     *
     * @param string                $externalId    ID for the external profile
     * @param UserObject|int|string $userTokenOrId User authentication token or user ID.
     *
     * @return BillingExternalGetProfileByExternalIdResponseObject
     *
     * @throws DisloException
     */
    public function billingExternalGetProfileByExternalId($externalId, $userTokenOrId = null) {
        $data = $this->userToData($userTokenOrId, [
            'externalId' => $externalId,
        ]);

        $response = $this->request(self::API_URI_BILLING_EXTERNAL_GET_PROFILE, $data);

        return BillingExternalGetProfileByExternalIdResponseObject::fromResponse($response);
    }

    /**
     * Retrieve an external profile by the external id that has been passed in "subscription/externalCreate".
     *
     * @see https://docs.dislo.com/display/DIS/ExternalGetProfile
     * @see https://docs.dislo.com/display/DIS/External+payments+guide
     *
     * @param SubscriptionObject|int $subscription  ID for the subscription expected to have an external profile
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return BillingExternalGetProfileBySubscriptionIdResponseObject
     *
     * @throws DisloException
     */
    public function billingExternalGetProfileBySubscriptionId($subscription, $userTokenOrId = null) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
        ]);

        $response = $this->request(self::API_URI_BILLING_EXTERNAL_GET_PROFILE, $data);

        return BillingExternalGetProfileBySubscriptionIdResponseObject::fromResponse($response);
    }

    /**
     * Get specific billing event.
     *
     * @see https://docs.dislo.com/display/DIS/GetBillingEvent
     *
     * @param int                   $billingEventId unique id of the billing event
     * @param UserObject|int|string $userTokenOrId  User authentication token or user ID.
     *
     * @return BillingGetEventResponseObject
     *
     * @throws DisloException
     */
    public function billingGetEvent($billingEventId, $userTokenOrId = null) {
        $data = $this->userToData($userTokenOrId, [
            'billingEventId' => $billingEventId,
        ]);

        $response = $this->request(self::API_URI_BILLING_GET_EVENT, $data);

        return BillingGetEventResponseObject::fromResponse($response);
    }

    /**
     * Get billing events for a user in paginated form.
     *
     * @see https://docs.dislo.com/display/DIS/GetBillingEventsForUser
     *
     * @param UserObject|int|string $userTokenOrId User authentication token or user ID.
     * @param int                   $limit
     * @param int                   $offset
     * @param string                $orderDir
     *
     * @return BillingGetEventsForUserResponseObject
     *
     * @throws DisloException
     */
    public function billingGetEventsForUser(
        $userTokenOrId,
        $limit = 10,
        $offset = 0,
        $orderDir = self::ORDER_DIR_ASC
    ) {
        $data = $this->userToData($userTokenOrId, [
            'limit'    => $limit,
            'offset'   => $offset,
            'orderDir' => $orderDir,
        ]);

        $response = $this->request(self::API_URI_BILLING_GET_EVENTS_FOR_USER, $data);

        return BillingGetEventsForUserResponseObject::fromResponse($response);
    }

    /**
     * Get flexible payment method for a user
     *
     * @param UserObject|int|string $userTokenOrId User authentication token or user ID.
     *
     * @return BillingGetFlexibleResponseObject
     *
     * @throws DisloException
     */
    public function billingGetFlexible($userTokenOrId) {
        $data = $this->userToData($userTokenOrId, []);

        $response = $this->request(self::API_URI_BILLING_GET_FLEXIBLE, $data);

        return BillingGetFlexibleResponseObject::fromResponse($response);
    }

    /**
     * Get specific flexible payment method for a user by its identifier
     *
     * @param int                   $flexibleIdentifier
     * @param UserObject|int|string $userTokenOrId User authentication token or user ID.
     *
     * @return BillingGetFlexibleByIdentifierResponseObject
     *
     * @throws DisloException
     * @throws ObjectNotFoundException
     */
    public function billingGetFlexibleByIdentifier($flexibleIdentifier, $userTokenOrId) {
        $data = $this->userToData($userTokenOrId, [
            'flexibleId' => $flexibleIdentifier
        ]);

        $response = $this->request(self::API_URI_BILLING_GET_FLEXIBLE_BY_ID, $data);

        return BillingGetFlexibleByIdentifierResponseObject::fromResponse($response);
    }

    /**
     * Get active recurring payment method for a subscription
     *
     * @param SubscriptionObject|int $subscription  ID for the subscription expected to have an external profile
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return BillingGetActiveRecurringResponseObject
     *
     * @throws DisloException
     */
    public function billingGetActiveRecurring($subscription, $userTokenOrId) {
        $data = $this->userToData($userTokenOrId, [
            ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
        ]);

        $response = $this->request(self::API_URI_BILLING_GET_ACTIVE_RECURRING, $data);

        return BillingGetActiveRecurringResponseObject::fromResponse($response);
    }

    /**
     * Close active recurring payment method for a subscription
     *
     * @param SubscriptionObject|int $subscription  ID for the subscription expected to have an external profile
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return BillingCloseActiveRecurringResponseObject
     *
     * @throws DisloException
     */
    public function billingCloseActiveRecurring($subscription, $userTokenOrId) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
        ]);

        $response = $this->request(self::API_URI_BILLING_CLOSE_ACTIVE_RECURRING, $data);

        return BillingCloseActiveRecurringResponseObject::fromResponse($response);
    }

    //endregion

    //region Subscription API calls

    /**
     * Calculate the price for a subscription addon.
     *
     * @see https://docs.dislo.com/display/DIS/CalculateAddonPrice
     *
     * @param SubscriptionObject|int $subscription
     * @param string|string[]        $packageIdentifiers
     * @param string|null            $couponCode
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return SubscriptionCalculateAddonPriceResponseObject
     *
     * @throws DisloException
     */
    public function subscriptionCalculateAddonPrice(
        $subscription,
        $packageIdentifiers,
        $couponCode = null,
        $userTokenOrId
    ) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId'     => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
            'packageIdentifiers' => $packageIdentifiers,
            'couponCode'         => $couponCode,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_CALCULATE_ADDON_PRICE, $data);

        return SubscriptionCalculateAddonPriceResponseObject::fromResponse($response);
    }

    /**
     * Calculate the price for a potential package change.
     *
     * @see https://docs.dislo.com/display/DIS/CalculatePackageChange
     *
     * @param SubscriptionObject|int $subscription
     * @param string                 $newPackageIdentifier
     * @param string|null            $couponCode
     * @param UserObject|string|int  $userTokenOrId User authentication token or user ID.
     * @param string[]               $addonPackageIdentifiers
     *
     * @return SubscriptionCalculatePackageChangeResponseObject
     */
    public function subscriptionCalculatePackageChange(
        $subscription,
        $newPackageIdentifier,
        $couponCode = null,
        $userTokenOrId = null,
        $addonPackageIdentifiers = []
    ) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId'          => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
            'newPackageIdentifier'    => $newPackageIdentifier,
            'couponCode'              => $couponCode,
            'addonPackageIdentifiers' => $addonPackageIdentifiers,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_CALCULATE_PACKAGE_CHANGE, $data);

        return SubscriptionCalculatePackageChangeResponseObject::fromResponse($response);
    }

    /**
     * Calculates the price for creating a new subscription for an existing user.
     *
     * @see https://docs.dislo.com/display/DIS/CalculateSubscriptionPrice
     *
     * @param string                $packageIdentifier       the package for the subscription
     * @param string                $currencyCode            currency which should be used for the user
     * @param string|null           $couponCode              optional - coupon which should be applied
     * @param string|string[]       $addonPackageIdentifiers optional - additional addon packages
     * @param UserObject|int|string $userTokenOrId           User authentication token or user ID.
     *
     * @return SubscriptionCalculatePriceResponseObject
     */
    public function subscriptionCalculatePrice(
        $packageIdentifier,
        $currencyCode,
        $couponCode = null,
        $addonPackageIdentifiers = [],
        $userTokenOrId
    ) {
        $data = $this->userToData($userTokenOrId, [
            'packageIdentifier'       => $packageIdentifier,
            'currencyCode'            => $currencyCode,
            'couponCode'              => $couponCode,
            'addonPackageIdentifiers' => $addonPackageIdentifiers,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_CALCULATE_PRICE, $data);

        return SubscriptionCalculatePriceResponseObject::fromResponse($response);
    }

    /**
     * Cancel a future package change
     *
     * NOTE: this call only works for package changes which are not applied immediately. In that case you need to call
     * ChangePackage again.
     *
     * @see https://docs.dislo.com/display/DIS/CancelPackageChange
     *
     * @param SubscriptionObject|int $subscription  the unique subscription id to change
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return SubscriptionCancelPackageChangeResponseObject
     */
    public function subscriptionCancelPackageChange($subscription, $userTokenOrId = null) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_CANCEL_PACKAGE_CHANGE, $data);

        return SubscriptionCancelPackageChangeResponseObject::fromResponse($response);
    }

    /**
     * Cancels a single subscription.
     *
     * @param SubscriptionObject|int $subscription     the id of the subscription you want to cancel
     * @param string                 $cancelReason     optional - the reason why the user canceled (should be predefined
     *                                                 reasons by your frontend)
     * @param string                 $userCancelReason optional - a user defined cancellation reason
     * @param string                 $userComments     optional - comments from the user
     * @param UserObject|int|string  $userTokenOrId    User authentication token or user ID.
     *
     * @return SubscriptionCancelResponseObject
     */
    public function subscriptionCancel(
        $subscription,
        $cancelReason = '',
        $userCancelReason = '',
        $userComments = '',
        $userTokenOrId = null
    ) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId'   => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
            'cancelReason'     => $cancelReason,
            'userCancelReason' => $userCancelReason,
            'userComments'     => $userComments,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_CANCEL, $data);

        return SubscriptionCancelResponseObject::fromResponse($response);
    }

    /**
     * Change the package for a subscription.
     *
     * @param SubscriptionObject|int $subscription            the unique subscription id to change
     * @param string                 $newPackageIdentifier    the identifier of the new package
     * @param string[]               $addonPackageIdentifiers optional - package identifiers of the addons
     * @param string                 $couponCode              optional - the coupon code to apply
     * @param array                  $metaData                optional - additional data (if supported by Dislo
     *                                                        installation)
     * @param bool                   $useFlexible             use the existing flexible payment method from the user to
     *                                                        pay for the package change immediately
     * @param UserObject|int|string  $userTokenOrId           User authentication token or user ID.
     *
     * @return SubscriptionChangeResponseObject
     */
    public function subscriptionChange(
        $subscription,
        $newPackageIdentifier,
        $addonPackageIdentifiers = [],
        $couponCode = '',
        $metaData = [],
        $useFlexible = false,
        $userTokenOrId = null
    ) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId'       => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
            'newPackageIdentifier' => $newPackageIdentifier,
            'useFlexible'          => $useFlexible,
        ]);

        if (!empty($addonPackageIdentifiers)) {
            $data['addonPackageIdentifiers'] = $addonPackageIdentifiers;
        }
        if (!empty($couponCode)) {
            $data['couponCode'] = $couponCode;
        }
        if (!empty($metaData)) {
            $data['metaData'] = $metaData;
        }

        $response = $this->request(self::API_URI_SUBSCRIPTION_CHANGE, $data);

        return SubscriptionChangeResponseObject::fromResponse($response);
    }

    /**
     * Check if a coupon code is valid.
     *
     * @param string      $couponCode
     * @param string|null $event @see self::COUPON_EVENT_*
     *
     * @return CouponCodeCheckResponseObject
     */
    public function couponCodeCheck($couponCode, $event = null) {
        $data = [
            'couponCode' => $couponCode,
        ];

        if (!empty($event)) {
            $data['event'] = $event;
        }

        $response = $this->request(self::API_URI_COUPON_CODE_CHECK, $data);

        return CouponCodeCheckResponseObject::fromResponse($response, $couponCode, $event);
    }

    /**
     * Closes a subscription immediately
     *
     * @param SubscriptionObject|int $subscription  the id of the subscription you want to close
     * @param string                 $closeReason   optional - the reason why the subscription was closed (should be
     *                                              predefined reasons by your frontend)
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return SubscriptionCloseResponseObject
     */
    public function subscriptionClose($subscription, $closeReason = '', $userTokenOrId = null) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
            'closeReason'    => $closeReason,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_CLOSE, $data);

        return SubscriptionCloseResponseObject::fromResponse($response);
    }

    /**
     * Continues a previously cancelled subscription (undo cancellation).
     *
     * @param SubscriptionObject|int $subscription  the id of the subscription you want to close
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return SubscriptionContinueResponseObject
     */
    public function subscriptionContinue($subscription, $userTokenOrId = null) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_CONTINUE, $data);

        return SubscriptionContinueResponseObject::fromResponse($response);
    }

    /**
     * Create an addon subscription.
     *
     * @param SubscriptionObject|int $subscription
     * @param string[]               $packageIdentifiers
     * @param string                 $couponCode
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return SubscriptionCreateAddonResponseObject
     */
    public function subscriptionCreateAddon($subscription, $packageIdentifiers, $couponCode = '', $userTokenOrId) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId'     => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
            'packageIdentifiers' => $packageIdentifiers,
        ]);

        if (!empty($couponCode)) {
            $data['couponCode'] = $couponCode;
        }

        $response = $this->request(self::API_URI_SUBSCRIPTION_CREATE_ADDON, $data);

        return SubscriptionCreateAddonResponseObject::fromResponse($response);
    }

    /**
     * Create a new subscription for a user, with optional addons.
     *
     * NOTE: users are locked to one currency code once their first subscription is created. You MUST pass the
     * users currency code in $currencyCode if it is already set up. You can obtain the currency code via
     * userGetBalance.
     *
     * NOTE: Always observe the needsBilling flag in the response. If it is true, call createPayment afterwards. If
     * it is false, you can use createFlexible to register a payment method without a payment. Don't mix up the two!
     *
     * @param UserObject|int|string $userTokenOrId User authentication token or user ID.
     * @param string                $packageIdentifier
     * @param string                $currencyCode
     * @param string                $couponCode
     * @param array                 $addonPackageIdentifiers
     *
     * @return SubscriptionCreateResponseObject
     */
    public function subscriptionCreate(
        $userTokenOrId,
        $packageIdentifier,
        $currencyCode,
        $couponCode = '',
        $addonPackageIdentifiers = []
    ) {
        $data = $this->userToData($userTokenOrId, [
            'packageIdentifier' => $packageIdentifier,
            'currencyCode'      => $currencyCode,
        ]);

        if (!empty($addonPackageIdentifiers)) {
            $data['addonPackageIdentifiers'] = $addonPackageIdentifiers;
        }
        if (!empty($couponCode)) {
            $data['couponCode'] = $couponCode;
        }

        $response = $this->request(self::API_URI_SUBSCRIPTION_CREATE, $data);

        return SubscriptionCreateResponseObject::fromResponse($response);
    }

    /**
     * Change the package for an external subscription.
     *
     * @param SubscriptionObject|int $subscription            the unique subscription id to change
     * @param string                 $newPackageIdentifier    the identifier for the new package.
     * @param \DateTime              $newPeriodEnd            end date, has to be >= now.
     * @param string[]               $addonPackageIdentifiers optional - package identifiers of the addons
     * @param null                   $newExternalId           if provided, a new external profile will be created for the
     *                                                        given subscription, the old one is invalidated
     * @param array                  $extraData               required when newExternalId is set, key value data for
     *                                                        external profile
     * @param UserObject|int|string  $userTokenOrId           User authentication token or user ID.
     *
     * @return SubscriptionExternalChangeResponseObject
     */
    public function subscriptionExternalChange(
        $subscription,
        $newPackageIdentifier,
        \DateTime $newPeriodEnd,
        $addonPackageIdentifiers = [],
        $newExternalId = null,
        $extraData = [],
        $userTokenOrId = null
    ) {
        $newPeriodEnd = clone $newPeriodEnd;

        $data = $this->userToData($userTokenOrId, [
            'subscriptionId'       => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
            'newPackageIdentifier' => $newPackageIdentifier,
            'newPeriodEnd'         => $newPeriodEnd
                ->setTimezone(new \DateTimeZone('UTC'))
                ->format('Y-m-d H:i:s'),
        ]);

        if (!empty($addonPackageIdentifiers)) {
            $data['addonPackageIdentifiers'] = $addonPackageIdentifiers;
        }
        if (!empty($newExternalId)) {
            $data['newExternalId'] = $newExternalId;
            $data['extraData']     = $extraData;
        }

        $response = $this->request(self::API_URI_SUBSCRIPTION_EXTERNAL_CHANGE, $data);

        return SubscriptionExternalChangeResponseObject::fromResponse($response);
    }

    /**
     * Change the period end of an external subscription
     *
     * @param SubscriptionObject|int $subscription
     * @param \DateTime              $newPeriodEnd
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return SubscriptionExternalChangePeriodResponseObject
     */
    public function subscriptionExternalChangePeriod($subscription, \DateTime $newPeriodEnd, $userTokenOrId = null) {
        $newPeriodEnd = clone $newPeriodEnd;

        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
            'newPeriodEnd'   => $newPeriodEnd
                ->setTimezone(new \DateTimeZone('UTC'))
                ->format('Y-m-d H:i:s'),
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_EXTERNAL_CHANGE_PERIOD, $data);

        return SubscriptionExternalChangePeriodResponseObject::fromResponse($response);
    }

    /**
     * Closes an external subscription immediately.
     *
     * @param SubscriptionObject|int $subscription
     * @param string                 $closeReason
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return SubscriptionExternalCloseResponseObject
     */
    public function subscriptionExternalClose($subscription, $closeReason = '', $userTokenOrId = null) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
        ]);

        if (!empty($closeReason)) {
            $data['closeReason'] = $closeReason;
        }

        $response = $this->request(self::API_URI_SUBSCRIPTION_EXTERNAL_CLOSE, $data);

        return SubscriptionExternalCloseResponseObject::fromResponse($response);
    }

    /**
     * Create an external addon subscription.
     *
     * @param SubscriptionObject|int $subscription
     * @param string[]               $packageIdentifiers
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return SubscriptionExternalAddonCreateResponseObject
     */
    public function subscriptionExternalAddonCreate($subscription, $packageIdentifiers, $userTokenOrId) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId'     => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
            'packageIdentifiers' => $packageIdentifiers,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_EXTERNAL_CREATE_ADDON_SUBSCRIPTION, $data);

        return SubscriptionExternalAddonCreateResponseObject::fromResponse($response);
    }

    /**
     * Create an external subscription.
     *
     * @param string                $packageIdentifier       the package for the subscription
     * @param string                $externalId              unique id for the external profile that is created for this
     *                                                       subscription
     * @param array                 $extraData               key/value array where you can save whatever you need with
     *                                                       the external profile, you can fetch this later on by
     *                                                       passing the externalId to "billing/externalGetProfile"
     * @param string                $currencyCode            currency which should be used for the user
     * @param array                 $addonPackageIdentifiers optional - additional addon packages
     * @param \DateTime|null        $periodEnd               end of the first period, if omitted, dislo will calculate
     *                                                       the period end itself by using the package duration
     * @param UserObject|int|string $userTokenOrId           User authentication token or user ID.
     *
     * @return SubscriptionExternalCreateResponseObject
     */
    public function subscriptionExternalCreate(
        $packageIdentifier,
        $externalId,
        $extraData,
        $currencyCode,
        $addonPackageIdentifiers = [],
        \DateTime $periodEnd = null,
        $userTokenOrId
    ) {
        $data = $this->userToData($userTokenOrId, [
            'packageIdentifier'       => $packageIdentifier,
            'externalId'              => $externalId,
            'extraData'               => $extraData,
            'currencyCode'            => $currencyCode,
            'addonPackageIdentifiers' => $addonPackageIdentifiers,
        ]);

        if (!empty($periodEnd)) {
            $periodEnd = clone $periodEnd;

            $data['periodEnd'] = $periodEnd
                ->setTimezone(new \DateTimeZone('UTC'))
                ->format('Y-m-d H:i:s');
        }

        $response = $this->request(self::API_URI_SUBSCRIPTION_EXTERNAL_CREATE, $data);

        return SubscriptionExternalCreateResponseObject::fromResponse($response);
    }

    /**
     * Call a service provider function related to the subscription. Specific calls depend on the SPI connected to
     * the service behind the subscription.
     *
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     * @param SubscriptionObject|int $subscriptionId
     * @param string                 $method
     * @param array                  $params
     * @param int|null               $serviceId
     *
     * @return SubscriptionCallSpiResponseObject
     */
    public function subscriptionCallSpi($userTokenOrId, $subscriptionId, $method, $params, $serviceId = null) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => ($subscriptionId instanceof SubscriptionObject)
                ? $subscriptionId->getSubscriptionId()
                : $subscriptionId,
            'method'         => $method,
            'params'         => $params,
            'serviceId'      => $serviceId,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_CALL_SPI, $data);

        return SubscriptionCallSpiResponseObject::fromResponse($response);
    }

    /**
     * Get packages to which the given subscription is able to change to.
     *
     * @param UserObject|int|string  $userTokenOrId
     * @param SubscriptionObject|int $subscriptionId
     * @param string                 $type           'queued' or 'immediate'
     *
     * @return SubscriptionGetPossiblePackageChangesResponseObject
     */
    public function subscriptionGetPossiblePackageChanges($userTokenOrId, $subscriptionId, $type = '') {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => ($subscriptionId instanceof SubscriptionObject)
                ? $subscriptionId->getSubscriptionId()
                : $subscriptionId,
        ]);

        if (!empty($type)) {
            $data['type'] = $type;
        }

        $response = $this->request(self::API_URI_SUBSCRIPTION_GET_POSSIBLE_PACKAGE_CHANGES, $data);

        return SubscriptionGetPossiblePackageChangesResponseObject::fromResponse($response);
    }

    /**
     * Retrieve a list of all packages registered in the system.
     *
     * @param string|null $serviceIdentifier
     *
     * @return PackagesListResponseObject
     */
    public function packageList($serviceIdentifier = null) {
        $data = [];
        if (!empty($serviceIdentifier)) {
            $data['serviceIdentifier'] = $serviceIdentifier;
        }

        $response = $this->request(self::API_URI_PACKAGE_LIST, $data);

        return PackagesListResponseObject::fromResponse($response);
    }

    /**
     * @param string $packageIdentifier
     *
     * @return PackageGetResponseObject
     *
     * @throws ObjectNotFoundException
     */
    public function packageGet($packageIdentifier) {
        $packages = $this->packageList(null)->getPackages();

        foreach ($packages as $package) {
            if ($package->getPackageIdentifier() == $packageIdentifier) {
                return new PackageGetResponseObject($package);
            }
        }

        throw new ObjectNotFoundException('Package with ID ' . $packageIdentifier);
    }

    /**
     * Retrieves a single subscription by its id.
     *
     * @param SubscriptionObject|int $subscription
     * @param UserObject|int|string  $userTokenOrId User authentication token or user ID.
     *
     * @return SubscriptionGetResponseObject
     */
    public function subscriptionGet($subscription, $userTokenOrId = null) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_GET, $data);

        return SubscriptionGetResponseObject::fromResponse($response);
    }

    /**
     * Retrieves all subscriptions for a user.
     *
     * @param UserObject|int|string $userTokenOrId User authentication token or user ID.
     *
     * @return SubscriptionGetAllResponseObject
     */
    public function subscriptionGetAll($userTokenOrId) {
        $data = $this->userToData($userTokenOrId, []);

        $response = $this->request(self::API_URI_SUBSCRIPTION_GET_ALL, $data);

        return SubscriptionGetAllResponseObject::fromResponse($response);
    }

    /**
     * Get the subscription period events in paginated form.
     *
     * @param int                        $subscriptionId
     * @param UserObject|int|string|null $userTokenOrId
     * @param int                        $limit
     * @param int                        $offset
     * @param string                     $orderDir
     *
     * @return SubscriptionGetPeriodEventsResponseObject
     */
    public function subscriptionGetPeriodEvents(
        $subscriptionId,
        $userTokenOrId = null,
        $limit = 10,
        $offset = 0,
        $orderDir = self::ORDER_DIR_ASC
    ) {
        $data = $this->userToData($userTokenOrId, [
            'subscriptionId' => $subscriptionId,
            'limit'          => $limit,
            'offset'         => $offset,
            'orderDir'       => $orderDir,
        ]);

        $response = $this->request(self::API_URI_SUBSCRIPTION_GET_PERIOD_EVENTS, $data);

        return SubscriptionGetPeriodEventsResponseObject::fromResponse($response);
    }

    /**
     * Check if a coupon is valid for the given context package/addons/event/user/sub and calculates the discounted
     * price, for new subscriptions.
     *
     * @param string $couponCode
     * @param string $packageIdentifier
     * @param array  $addonPackageIdentifiers
     * @param string $currencyCode
     *
     * @return CouponCodeValidateNewResponseObject
     */
    public function couponCodeValidateNew(
        $couponCode,
        $packageIdentifier,
        $addonPackageIdentifiers = [],
        $currencyCode
    ) {
        $data = [
            'couponCode'              => $couponCode,
            'packageIdentifier'       => $packageIdentifier,
            'addonPackageIdentifiers' => $addonPackageIdentifiers,
            'event'                   => self::COUPON_EVENT_START,
            'currencyCode'            => $currencyCode,
        ];

        $response = $this->request(self::API_URI_COUPON_CODE_VALIDATE, $data);

        return CouponCodeValidateNewResponseObject::fromResponse($response, $couponCode, self::COUPON_EVENT_START);
    }

    /**
     * Check if a coupon is valid for the given context package/addons/event/user/sub and calculates the discounted
     * price, for upgrades
     *
     * @param string                 $couponCode
     * @param string                 $packageIdentifier
     * @param array                  $addonPackageIdentifiers
     * @param string                 $currencyCode
     * @param UserObject|string|int  $userTokenOrId
     * @param SubscriptionObject|int $subscription
     *
     * @return CouponCodeValidateUpgradeResponseObject
     */
    public function couponCodeValidateUpgrade(
        $couponCode,
        $packageIdentifier,
        $addonPackageIdentifiers,
        $currencyCode,
        $subscription,
        $userTokenOrId = null
    ) {
        $data = $this->userToData($userTokenOrId, [
            'couponCode'              => $couponCode,
            'packageIdentifier'       => $packageIdentifier,
            'addonPackageIdentifiers' => $addonPackageIdentifiers,
            'event'                   => self::COUPON_EVENT_UPGRADE,
            'currencyCode'            => $currencyCode,
            'subscriptionId'          => ($subscription instanceof SubscriptionObject)
                ? $subscription->getSubscriptionId()
                : $subscription,
        ]);

        $response = $this->request(self::API_URI_COUPON_CODE_VALIDATE, $data);

        return CouponCodeValidateUpgradeResponseObject::fromResponse($response, $couponCode, self::COUPON_EVENT_UPGRADE);
    }

    //endregion

    //region User API calls

    /**
     * Authenticate a user. Returns an access token for subsequent API calls.
     *
     * @param string      $username        Username.
     * @param string      $password        User password.
     * @param string      $ipAddress       IP address of the user attempting to authenticate.
     * @param int         $tokenLifetime   Authentication token lifetime in seconds. TokenLifeTime is renewed and extended
     *                                     by API calls automatically, using the inital tokenlifetime.
     * @param string      $metainfo        Meta information to store with token (4096 bytes)
     * @param bool        $ignoreRateLimit
     * @param string|null $language
     *
     * @return UserAuthenticateResponseObject
     *
     * @throws AuthenticationException
     * @throws AuthenticationInvalidCredentialsException
     * @throws AuthenticationRateLimitedException
     * @throws DisloException
     * @throws ObjectNotFoundException
     * @throws \Exception
     */
    public function userAuthenticate(
        $username,
        $password,
        $ipAddress,
        $tokenLifetime = 1800,
        $metainfo = '',
        $ignoreRateLimit = false,
        $language = null
    ) {
        $data = [
            'username'        => $username,
            'password'        => $password,
            'ipAddress'       => $ipAddress,
            'tokenlifetime'   => \round($tokenLifetime / 60),
            'metainfo'        => $metainfo,
            'ignoreRateLimit' => $ignoreRateLimit,
            'language'        => $language,
        ];
        $response = $this->request(self::API_URI_USER_AUTHENTICATE, $data);

        if (!empty($response['error'])) {
            switch ($response['error']) {
                case 'rate_limit':
                    throw new AuthenticationRateLimitedException($username);
                case 'invalid_credentials':
                    throw new AuthenticationInvalidCredentialsException($username);
                case null;
                    break;
                default:
                    throw new AuthenticationException($username);
            }
        }

        return UserAuthenticateResponseObject::fromResponse($response);
    }

    /**
     * Deauthenticate a token.
     *
     * @param string $authToken
     *
     * @return UserDeauthenticateResponseObject
     */
    public function userDeauthenticate($authToken) {
        $data     = [
            'authToken' => $authToken,
        ];

        $response = $this->request(self::API_URI_USER_DEAUTHENTICATE, $data);

        return UserDeauthenticateResponseObject::fromResponse($response);
    }

    /**
     * Change data of an existing user.
     *
     * @param UserObject|string|int $userTokenOrId the unique user id to change
     * @param string                $language      iso-2-letter language key to use for this user
     * @param string[]              $metaData      meta data for this user (such as first name, last names etc.). NOTE: these
     *                                             meta data keys must exist in the meta data profile in Distribload
     *
     * @return UserChangeResponseObject
     */
    public function userChange($userTokenOrId, $language, $metaData) {
        $data = $this->userToData($userTokenOrId, [
            'language' => $language,
            'metaData' => $metaData,
        ]);

        $response = $this->request(self::API_URI_USER_CHANGE, $data);

        return UserChangeResponseObject::fromResponse($response);
    }

    /**
     * Change password of an existing user.
     *
     * @param UserObject|string|int $userTokenOrId the unique user id to change
     * @param string                $newPassword   the new password
     *
     * @return UserChangePasswordResponseObject
     */
    public function userChangePassword($userTokenOrId, $newPassword) {
        $data = $this->userToData($userTokenOrId, [
            'plaintextPassword' => $newPassword,
        ]);

        $response = $this->request(self::API_URI_USER_CHANGE_PASSWORD, $data);

        return UserChangePasswordResponseObject::fromResponse($response);
    }

    /**
     * Creates a new user with the given meta data.
     *
     * @param string   $language          iso-2-letter language key to use for this user
     * @param string   $plaintextPassword password for this user
     * @param string[] $metaData          meta data for this user (such as first name, last names etc.). NOTE: these
     *                                    meta data keys must exist in the meta data profile in Distribload
     *
     * @return UserCreateResponseObject
     */
    public function userCreate($language, $plaintextPassword, $metaData) {
        $data = [
            'language'          => $language,
            'plaintextPassword' => $plaintextPassword,
            'metaData'          => $metaData,
        ];

        $response = $this->request(self::API_URI_USER_CREATE, $data);

        return UserCreateResponseObject::fromResponse($response);
    }

    /**
     * Soft-delete a user.
     *
     * @param UserObject|string|int $userTokenOrId
     *
     * @return UserDeleteResponseObject
     */
    public function userDelete($userTokenOrId) {
        $data = $this->userToData($userTokenOrId, []);

        $response = $this->request(self::API_URI_USER_DELETE, $data);

        return UserDeleteResponseObject::fromResponse($response);
    }

    /**
     * Disable website login capability for user.
     *
     * @param UserObject|string|int $userTokenOrId
     *
     * @return UserDisableLoginResponseObject
     */
    public function userDisableLogin($userTokenOrId) {
        $data = $this->userToData($userTokenOrId, []);

        $response = $this->request(self::API_URI_USER_DISABLE_LOGIN, $data);

        return UserDisableLoginResponseObject::fromResponse($response);
    }

    /**
     * Enable website login capability for user.
     *
     * @param UserObject|string|int $userTokenOrId
     *
     * @return UserEnableLoginResponseObject
     */
    public function userEnableLogin($userTokenOrId) {
        $data = $this->userToData($userTokenOrId, []);

        $response = $this->request(self::API_URI_USER_ENABLE_LOGIN, $data);

        return UserEnableLoginResponseObject::fromResponse($response);
    }

    /**
     * Get a user's balance.
     *
     * @param UserObject|string|int $userTokenOrId
     *
     * @return UserGetBalanceResponseObject
     */
    public function userGetAccountBalance($userTokenOrId) {
        $data = $this->userToData($userTokenOrId, []);

        $response = $this->request(self::API_URI_USER_GET_ACCOUNT_BALANCE, $data);

        return UserGetBalanceResponseObject::fromResponse($response);
    }

    /**
     * Retrieve a list of metadata elements.
     *
     * @return UserGetMetaProfileResponseObject
     */
    public function userGetMetaProfile() {
        $response = $this->request(self::API_URI_USER_GET_META_PROFILE, []);

        return UserGetMetaProfileResponseObject::fromResponse($response);
    }

    /**
     * Retrieves the users authentication tokens.
     *
     * @param UserObject|string|int $userTokenOrId
     *
     * @return UserGetTokensResponseObject
     */
    public function userGetTokens($userTokenOrId) {
        $data = $this->userToData($userTokenOrId, []);

        $response = $this->request(self::API_URI_USER_GET_AUTH_TOKENS, $data);

        return UserGetTokensResponseObject::fromResponse($response);
    }

    /**
     * Retrieves a user.
     *
     * @param UserObject|string|int $userTokenOrId
     *
     * @return UserGetResponseObject
     */
    public function userGet($userTokenOrId) {
        $data = $this->userToData($userTokenOrId, []);

        $response = $this->request(self::API_URI_USER_GET, $data);

        return UserGetResponseObject::fromResponse($response);
    }

    /**
     * Update a users AuthToken MetaInfo
     *
     * @param string $authToken
     * @param string $metaInfo
     * @param string $ipAddress
     *
     * @return UserUpdateTokenResponseObject
     */
    public function userUpdateToken($authToken, $metaInfo, $ipAddress = '') {
        $data = [
            'authToken' => $authToken,
            'metaInfo'  => $metaInfo,
        ];

        if (!empty($ipAddress)) {
            $data['ipAddress'] = $ipAddress;
        }

        $response = $this->request(self::API_URI_USER_UPDATE_AUTH_TOKEN, $data);

        return UserUpdateTokenResponseObject::fromResponse($response);
    }

    /**
     * Extend a users AuthToken expiry time
     *
     * @param string   $authToken
     * @param string   $ipAddress
     * @param int|null $tokenLifetime   Omit to use lifetime set initially
     *
     * @return UserExtendTokenResponseObject
     */
    public function userExtendToken($authToken, $ipAddress = '', $tokenLifetime = null) {
        $data = [
            'authToken' => $authToken,
        ];

        if (!empty($ipAddress)) {
            $data['ipAddress'] = $ipAddress;
        }
        if (isset($tokenLifetime)) {
            $data['tokenlifetime'] = \round($tokenLifetime / 60);
        }

        $response = $this->request(self::API_URI_USER_EXTEND_AUTH_TOKEN, $data);

        return UserExtendTokenResponseObject::fromResponse($response);
    }

    /**
     * Get user with validated frontend auth token.
     *
     * @param string $authToken
     * @param string $ipAddress
     *
     * @return UserGetAuthenticatedResponseObject
     */
    public function userGetAuthenticated($authToken, $ipAddress = '') {
        $data = [
            'authToken' => $authToken,
        ];

        if (!empty($ipAddress)) {
            $data['ipAddress'] = $ipAddress;
        }

        $response = $this->request(self::API_URI_USER_GET_AUTHENTICATED, $data);

        return UserGetAuthenticatedResponseObject::fromResponse($response);
    }

    /**
     * Searches among the unique properties of all users in order to find one user. The search term must match exactly.
     *
     * @param string $searchTerm
     *
     * @return UserFindResponseObject
     *
     * @throws ObjectNotFoundException
     */
    public function userFind($searchTerm) {
        $data = [
            'searchTerm' => $searchTerm,
        ];

        $response = $this->request(self::API_URI_USER_FIND, $data);

        return UserFindResponseObject::fromResponse($response);
    }


    /**
     * Start the user recovery process.
     *
     * @param string $userIdentifier Unique identifier for the user needing recovery.
     * @param string $ipAddress      IP address of the request.
     * @param string $resetLink      Link the user can click to do password recovery. %s will be replaced with the
     *                               recovery code.
     *
     * @return UserRecoveryStartResponseObject
     */
    public function userRecoveryStart($userIdentifier, $ipAddress, $resetLink) {
        $data = [
            'identifier' => $userIdentifier,
            'ipAddress'  => $ipAddress,
            'resetLink'  => $resetLink,
        ];

        $response = $this->request(self::API_URI_USER_RECOVERY_START, $data);

        return UserRecoveryStartResponseObject::fromResponse($response);
    }

    /**
     * Check if a given token is valid.
     *
     * @param string $recoveryToken
     * @param string $ipAddress
     *
     * @return UserRecoveryCheckResponseObject
     */
    public function userRecoveryCheck($recoveryToken, $ipAddress) {
        $data = [
            'recoveryToken' => $recoveryToken,
            'ipAddress'     => (string)$ipAddress,
        ];

        $response = $this->request(self::API_URI_USER_RECOVERY_CHECK, $data);

        return UserRecoveryCheckResponseObject::fromResponse($response);
    }

    /**
     * Finish the account recovery process.
     *
     * @param string $recoveryToken
     * @param string $ipAddress
     * @param string $newPassword
     *
     * @return UserRecoveryFinishResponseObject
     *
     * @throws ObjectNotFoundException
     */
    public function userRecoveryFinish($recoveryToken, $ipAddress, $newPassword) {
        $data = [
            'recoveryToken'     => $recoveryToken,
            'ipAddress'         => $ipAddress,
            'plaintextPassword' => $newPassword,
        ];

        $response = $this->request(self::API_URI_USER_RECOVERY_FINISH, $data);

        return UserRecoveryFinishResponseObject::fromResponse($response);
    }

    /**
     * Starts the User Verification ProcessWhen using this call, the user will receive an email to his stored email
     * address which gives instruction on how to verify. The email message must be configured by using the template
     * "token-verification".
     *
     * @param string|int|UserObject $userTokenOrId
     * @param string                $ipAddress
     * @param string                $verificationLink
     *
     * @return UserEmailVerificationStartResponseObject
     */
    public function userEmailVerificationStart($userTokenOrId, $ipAddress, $verificationLink) {
        $data = $this->userToData($userTokenOrId, [
            'verificationLink' => $verificationLink,
            'ipAddress'        => (string)$ipAddress,
            'verificationType' => 'email',
        ]);

        $response = $this->request(self::API_URI_USER_VERIFICATION_START, $data);

        return UserEmailVerificationStartResponseObject::fromResponse($response);
    }

    /**
     * Finalizes the users verification Process
     *
     * @param $verificationToken
     *
     * @return UserEmailVerificationFinishResponseObject
     */
    public function userEmailVerificationFinish($verificationToken) {
        $data = [
            'verificationToken' => $verificationToken,
            'verificationType'  => 'email',
        ];

        $response = $this->request(self::API_URI_USER_VERIFICATION_FINISH, $data);

        return UserEmailVerificationFinishResponseObject::fromResponse($response);
    }

    /**
     * @param string|int|UserObject $userTokenOrId
     * @param string                $ipAddress
     * @param string                $phoneNumber
     *
     * @return UserPhoneVerificationStartResponseObject
     */
    public function userPhoneVerificationStart($userTokenOrId, $ipAddress, $phoneNumber) {
        $data = $this->userToData($userTokenOrId, [
            'verificationType' => 'phone',
            'ipAddress'        => (string)$ipAddress,
            'extraData'        => [
                'phoneNumber' => $phoneNumber,
            ],
        ]);

        $response = $this->request(self::API_URI_USER_VERIFICATION_START, $data);

        return UserPhoneVerificationStartResponseObject::fromResponse($response);
    }

    /**
     * @param string|int|UserObject $userTokenOrId
     * @param string                $verificationPin
     * @param string|null           $phoneNumber
     *
     * @return UserPhoneVerificationFinishResponseObject
     */
    public function userPhoneVerificationFinish($userTokenOrId, $verificationPin, $phoneNumber = null) {
        $data = $this->userToData($userTokenOrId, [
            'verificationType' => 'phone',
            'verificationPin'  => $verificationPin,
            'phoneNumber'      => $phoneNumber,
        ]);

        $response = $this->request(self::API_URI_USER_VERIFICATION_FINISH, $data);

        return UserPhoneVerificationFinishResponseObject::fromResponse($response);
    }

    /**
     * @param string|int|UserObject $userTokenOdId
     * @param string                $ipAddress
     * @param string                $phoneNumber
     *
     * @return UserSmsVerificationStartResponseObject
     */
    public function userSmsVerificationStart($userTokenOdId, $ipAddress, $phoneNumber) {
        $data = $this->userToData($userTokenOdId, [
            'verificationType' => 'sms',
            'ipAddress'        => (string)$ipAddress,
            'extraData'        => [
                'phoneNumber' => $phoneNumber,
            ],
        ]);

        $response = $this->request(self::API_URI_USER_VERIFICATION_START, $data);

        return UserSmsVerificationStartResponseObject::fromResponse($response);
    }

    /**
     * @param string|int|UserObject $userTokenOrId
     * @param string                $verificationPin
     * @param string|null           $phoneNumber
     *
     * @return UserSmsVerificationFinishResponseObject
     */
    public function userSmsVerificationFinish($userTokenOrId, $verificationPin, $phoneNumber = null) {
        $data = $this->userToData($userTokenOrId, [
            'verificationType' => 'sms',
            'verificationPin'  => $verificationPin,
            'phoneNumber'      => $phoneNumber,
        ]);

        $response = $this->request(self::API_URI_USER_VERIFICATION_FINISH, $data);

        return UserSmsVerificationFinishResponseObject::fromResponse($response);
    }

    //endregion

    //region Redirector API calls

    /**
     * Retrieve Dislo's redirector configuration
     *
     * @return MiscGetRedirectorConfigurationResponseObject
     */
    public function miscGetRedirectorConfiguration() {
        $response = $this->request(self::API_URI_REDIRECTOR_GET_CONFIGURATION, []);

        return MiscGetRedirectorConfigurationResponseObject::fromResponse($response);
    }

    //endregion

    //region Report and query API calls

    /**
     * Run a stored report against Dislo's search database streaming the returned data. Requires a RequestClient with
     * streaming support.
     *
     * @param int             $reportId as shown in Dislo's administrator interface
     * @param array|null      $parameters name/value pairs to fill placeholders within the report
     * @param mixed|null      $stream String, resource, object or interface to stream the response body to, default to stdout
     *
     * @return StreamInterface
     */
    public function exportStreamReport($reportId, $parameters = null, $stream = null) {
        $data = [];
        if (!empty($parameters)) {
            $data['parameters'] = $parameters;
        }

        if (!$stream) {
            $stream = \fopen('php://stdout', 'w');
        }

        return $this->getRequestClientExtra()->requestStream(self::API_URI_EXPORT_STREAM_REPORT . $reportId, $data, $stream);
    }

    /**
     * Run a query against Dislo's search database streaming the returned data. Requires a RequestClient with
     * streaming support.
     *
     * @param string          $query SQL statement to execute, may contain ":_name(type)" placeholders
     * @param array|null      $parameters name/value pairs to fill placeholders within the query
     * @param mixed|null      $stream String, resource, object or interface to stream the response body to, default to stdout
     *
     * @return StreamInterface
     */
    public function exportStreamQuery($query, $parameters = null, $stream = null) {
        $data = [
            'query' => $query
        ];

        if (!empty($parameters)) {
            $data['parameters'] = $parameters;
        }

        if (!$stream) {
            $stream = \fopen('php://stdout', 'w');
        }

        return $this->getRequestClientExtra()->requestStream(self::API_URI_EXPORT_STREAM_QUERY, $data, $stream);
    }

    /**
     * Run a stored report against Dislo's search database returning the result as string. Keep memory limits in mind!
     *
     * @param int             $reportId as shown in Dislo's administrator interface
     * @param array|null      $parameters name/value pairs to fill placeholders within the report
     *
     * @return string
     */
    public function exportReport($reportId, $parameters = null) {
        return $this->exportStreamReport($reportId, $parameters, \fopen('php://temp', 'w+'))->getContents();
    }

    /**
     * Run a query against Dislo's search database returning the result as string. Keep memory limits im mind!
     *
     * @param string          $query SQL statement to execute, may contain ":_name(type)" placeholders
     * @param array|null      $parameters name/value pairs to fill placeholders within the query
     *
     * @return string
     */
    public function exportQuery($query, $parameters = null) {
        return $this->exportStreamQuery($query, $parameters, \fopen('php://temp', 'w+'))->getContents();
    }

    //endregion

}