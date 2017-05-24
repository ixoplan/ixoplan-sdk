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
use Ixolit\Dislo\Response\SubscriptionCalculateAddonPriceResponse;
use Ixolit\Dislo\Response\SubscriptionCalculatePackageChangeResponse;
use Ixolit\Dislo\Response\SubscriptionCalculatePriceResponse;
use Ixolit\Dislo\Response\SubscriptionCallSpiResponse;
use Ixolit\Dislo\Response\SubscriptionCancelPackageChangeResponse;
use Ixolit\Dislo\Response\SubscriptionCancelResponse;
use Ixolit\Dislo\Response\SubscriptionChangeResponse;
use Ixolit\Dislo\Response\SubscriptionCloseResponse;
use Ixolit\Dislo\Response\SubscriptionContinueResponse;
use Ixolit\Dislo\Response\SubscriptionCreateAddonResponse;
use Ixolit\Dislo\Response\SubscriptionCreateResponse;
use Ixolit\Dislo\Response\SubscriptionExternalAddonCreateResponse;
use Ixolit\Dislo\Response\SubscriptionExternalChangePeriodResponse;
use Ixolit\Dislo\Response\SubscriptionExternalChangeResponse;
use Ixolit\Dislo\Response\SubscriptionExternalCloseResponse;
use Ixolit\Dislo\Response\SubscriptionExternalCreateResponse;
use Ixolit\Dislo\Response\SubscriptionGetAllResponse;
use Ixolit\Dislo\Response\SubscriptionGetPossibleUpgradesResponse;
use Ixolit\Dislo\Response\SubscriptionGetResponse;
use Ixolit\Dislo\Response\UserAuthenticateResponse;
use Ixolit\Dislo\Response\UserChangeResponse;
use Ixolit\Dislo\Response\UserCreateResponse;
use Ixolit\Dislo\Response\UserDeauthenticateResponse;
use Ixolit\Dislo\Response\UserDeleteResponse;
use Ixolit\Dislo\Response\UserDisableLoginResponse;
use Ixolit\Dislo\Response\UserEmailVerificationFinishResponse;
use Ixolit\Dislo\Response\UserEmailVerificationStartResponse;
use Ixolit\Dislo\Response\UserEnableLoginResponse;
use Ixolit\Dislo\Response\UserFindResponse;
use Ixolit\Dislo\Response\UserGetBalanceResponse;
use Ixolit\Dislo\Response\UserGetMetaProfileResponse;
use Ixolit\Dislo\Response\UserGetResponse;
use Ixolit\Dislo\Response\UserGetSignupStatusResponse;
use Ixolit\Dislo\Response\UserGetTokensResponse;
use Ixolit\Dislo\Response\UserPhoneVerificationFinishResponse;
use Ixolit\Dislo\Response\UserPhoneVerificationStartResponse;
use Ixolit\Dislo\Response\UserRecoveryCheckResponse;
use Ixolit\Dislo\Response\UserRecoveryFinishResponse;
use Ixolit\Dislo\Response\UserRecoveryStartResponse;
use Ixolit\Dislo\Response\UserSmsVerificationFinishResponse;
use Ixolit\Dislo\Response\UserSmsVerificationStartResponse;
use Ixolit\Dislo\Response\UserUpdateTokenResponse;
use Ixolit\Dislo\Response\UserVerificationStartResponse;
use Ixolit\Dislo\WorkingObjects\Flexible;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjects\User;
use Psr\Http\Message\StreamInterface;

/**
 * The main client class for use with the Dislo API.
 *
 * Designed for different transport layers. Requires a RequestClient interface for actual communication with Dislo
 * (e.g. HTTPRequestClient).
 *
 * For details about the Dislo API, the available calls and Dislo itself please read the documentation available at
 * https://docs.dislo.com/
 */
class Client {
	const COUPON_EVENT_START    = 'subscription_start';
	const COUPON_EVENT_UPGRADE  = 'subscription_upgrade';

	const PLAN_CHANGE_IMMEDIATE = 'immediate';
	const PLAN_CHANGE_QUEUED    = 'queued';

	/**
	 * @var RequestClient
	 */
	private $requestClient;
	/**
	 * @var bool
	 */
	private $forceTokenMode;

	/**
	 * @return RequestClientExtra
	 *
	 * @throws NotImplementedException
	 */
	private function getRequestClientExtra() {
		if ($this->requestClient instanceof RequestClientExtra) {
			return $this->requestClient;
		}
		else {
			throw new NotImplementedException();
		}
	}

	private function userToData($userTokenOrId, &$data = []) {
		if ($this->forceTokenMode) {
			$data['authToken'] = $userTokenOrId;
			return $data;
		}
		if ($userTokenOrId instanceof User) {
			$data['userId'] = $userTokenOrId->getUserId();
			return $data;
		}
		if (\is_null($userTokenOrId)) {
			return $data;
		}
		if (\is_bool($userTokenOrId) || \is_float($userTokenOrId) || \is_resource($userTokenOrId) ||
			\is_array($userTokenOrId)
		) {
			throw new \InvalidArgumentException('Invalid user specification: ' . \var_export($userTokenOrId, true));
		}
		if (\is_object($userTokenOrId)) {
			if (!\method_exists($userTokenOrId, '__toString')) {
				throw new \InvalidArgumentException('Invalid user specification: ' . \var_export($userTokenOrId, true));
			}
			$userTokenOrId = $userTokenOrId->__toString();
		}

		if (\is_int($userTokenOrId) || \preg_match('/^[1-9][0-9]+$/D', $userTokenOrId)) {
			$data['userId'] = (int)$userTokenOrId;
		} else {
			$data['authToken'] = $userTokenOrId;
		}
		return $data;
	}

	/**
	 * Perform a request and handle errors.
	 *
	 * @param string $uri
	 * @param array  $data
	 *
	 * @return array
	 *
	 * @throws DisloException
	 * @throws ObjectNotFoundException
	 */
	private function request($uri, $data) {
		try {
			$response = $this->requestClient->request($uri, $data);
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
			} else {
				return $response;
			}
		} catch (ObjectNotFoundException $e) {
			throw $e;
		} catch (DisloException $e) {
			throw $e;
		} catch (\Exception $e) {
			throw new DisloException($e->getMessage(), $e->getCode(), $e);
		}
	}

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
		if (!($requestClient instanceof RequestClient)) {
			throw new DisloException('A RequestClient parameter is required!');
		}
		$this->requestClient  = $requestClient;
		$this->forceTokenMode = $forceTokenMode;
	}

	/**
	 * Retrieve the list of payment methods.
	 *
	 * @param string|null $packageIdentifier
	 * @param string|null $countryCode
	 *
	 * @return BillingMethodsGetResponse
	 */
	public function billingMethodsGet(
		$packageIdentifier = null,
		$countryCode = null
	) {
		if (!$packageIdentifier) {
			$response = $this->request('/frontend/billing/getPaymentMethods', []);
		} else {
			$response = $this->request('/frontend/billing/getPaymentMethodsForPackage', [
				'packageIdentifier' => $packageIdentifier,
				'countryCode' => $countryCode
			]);
		}
		return BillingMethodsGetResponse::fromResponse($response);
	}

	/**
	 * Retrieve the list of available payment methods.
	 *
	 * @param string|null $packageIdentifier
	 * @param string|null $countryCode
	 *
	 * @return BillingMethodsGetAvailableResponse
	 */
	public function billingMethodsGetAvailable(
		$packageIdentifier = null,
		$countryCode = null
	) {
		$billingMethods = $this->billingMethodsGet($packageIdentifier, $countryCode)->getBillingMethods();
		$availableBillingMethods = [];
		foreach ($billingMethods as $billingMethod) {
			if ($billingMethod->isAvailable()) {
				$availableBillingMethods[] = $billingMethod;
			}
		}

		return new BillingMethodsGetAvailableResponse($availableBillingMethods);
	}

	/**
	 * Closes the flexible payment method for a user.
	 *
	 * Note: once you close an active flexible, subscriptions cannot get extended automatically!
	 *
	 * @see https://docs.dislo.com/display/DIS/CloseFlexible
	 *
	 * @param Flexible|int    $flexible
	 * @param User|int|string $userTokenOrId User authentication token or user ID.
	 *
	 * @return BillingCloseFlexibleResponse
	 *
	 * @throws DisloException
	 */
	public function billingCloseFlexible(
		$flexible,
		$userTokenOrId = null
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$data['flexibleId'] = ($flexible instanceof Flexible ? $flexible->getFlexibleId() : (int)$flexible);

		$response = $this->request('/frontend/billing/closeFlexible', $data);
		return BillingCloseFlexibleResponse::fromResponse($response);
	}

	/**
	 * Create a new flexible for a user.
	 *
	 * Note: there can only be ONE active flexible per user. In case there is already an active one, and you
	 * successfully create a new one, the old flexible will be closed automatically.
	 *
	 * @see https://docs.dislo.com/display/DIS/CreateFlexible
	 *
	 * @param User|int|string $userTokenOrId User authentication token or user ID.
	 * @param string          $billingMethod
	 * @param string          $returnUrl
	 * @param array           $paymentDetails
	 * @param string          $currencyCode
	 *
	 * @return BillingCreateFlexibleResponse
	 *
	 * @throws DisloException
	 */
	public function billingCreateFlexible(
		$userTokenOrId,
		$billingMethod,
		$returnUrl,
		$paymentDetails,
		$currencyCode = ''
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$data['billingMethod']  = $billingMethod;
		$data['returnUrl']      = (string)$returnUrl;
		$data['paymentDetails'] = $paymentDetails;
		if ($currencyCode) {
			$data['currencyCode'] = $currencyCode;
		}
		$response = $this->request('/frontend/billing/createFlexible', $data);
		return BillingCreateFlexibleResponse::fromResponse($response);
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
	 * @param Subscription|int $subscription
	 * @param string           $billingMethod
	 * @param string           $returnUrl
	 * @param array            $paymentDetails
	 * @param User|int|string  $userTokenOrId user authentication token or id
	 * @param string|null      $countryCode
	 *
	 * @return BillingCreatePaymentResponse
	 */
	public function billingCreatePayment(
		$subscription,
		$billingMethod,
		$returnUrl,
		$paymentDetails,
		$userTokenOrId = null,
		$countryCode = null
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$data['billingMethod']  = $billingMethod;
		$data['returnUrl']      = (string)$returnUrl;
		$data['subscriptionId'] =
			($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription);
		$data['paymentDetails'] = $paymentDetails;
		$data['countryCode'] = $countryCode;
		$response               = $this->request('/frontend/billing/createPayment', $data);
		if (!$response['redirectUrl']) {
			$response['redirectUrl'] = $returnUrl;
		}
		return BillingCreatePaymentResponse::fromResponse($response);
	}

	/**
	 * Create an external charge.
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalCreateCharge
	 * @see https://docs.dislo.com/display/DIS/External+payments+guide
	 *
	 * @param string          $externalProfileId     the external profile to which the charge should be linked, this is
	 *                                               the "externalId" you passed in the "subscription/externalCreate"
	 *                                               call
	 * @param string          $accountIdentifier     the billing account identifier, you will this from dislo staff
	 * @param string          $currencyCode          currency code EUR, USD, ...
	 * @param float           $amount                the amount of the charge
	 * @param string          $externalTransactionId external unique id for the charge
	 * @param int|null        $upgradeId             the unique upgrade id to which the charge should be linked, you
	 *                                               get this from the "subscription/externalChangePackage" or
	 *                                               "subscription/externalCreateAddonSubscription" call
	 * @param array           $paymentDetails        additional data you want to save with the charge
	 * @param string          $description           description of the charge
	 * @param string          $status                status the charge should be created with, you might want to log
	 *                                               erroneous charges in dislo too, but you don't have to. @see
	 *                                               BillingEvent::STATUS_*
	 * @param User|int|string $userTokenOrId         User authentication token or user ID.
	 *
	 * @return BillingExternalCreateChargeResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalCreateCharge(
		$externalProfileId,
		$accountIdentifier,
		$currencyCode,
		$amount,
		$externalTransactionId,
		$upgradeId = null,
		$paymentDetails = [],
		$description = '',
		$status = 'success',
		$userTokenOrId = null
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$data['externalProfileId']     = $externalProfileId;
		$data['accountIdentifier']     = $accountIdentifier;
		$data['currencyCode']          = $currencyCode;
		$data['amount']                = $amount;
		$data['externalTransactionId'] = $externalTransactionId;
		$data['upgradeId']             = $upgradeId;
		$data['paymentDetails']        = $paymentDetails;
		$data['description']           = $description;
		$data['status']                = $status;

		$response = $this->request('/frontend/billing/externalCreateCharge', $data);
		return BillingExternalCreateChargeResponse::fromResponse($response);
	}

	/**
	 * Create an external charge.
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalCreateChargeWithoutProfile
	 *
	 * @param string          $accountIdentifier     the billing account identifier, you will this from dislo staff
	 * @param string          $currencyCode          currency code EUR, USD, ...
	 * @param float           $amount                the amount of the charge
	 * @param string          $externalTransactionId external unique id for the charge
	 * @param array           $paymentDetails        additional data you want to save with the charge
	 * @param string          $description           description of the charge
	 * @param string          $status                status the charge should be created with, you might want to log
	 *                                               erroneous charges in dislo too, but you don't have to. @see
	 *                                               BillingEvent::STATUS_*
	 * @param User|int|string $userTokenOrId         User authentication token or user ID.
	 *
	 * @return BillingExternalCreateChargeResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalCreateChargeWithoutProfile(
		$accountIdentifier,
		$currencyCode,
		$amount,
		$externalTransactionId = null,
		$paymentDetails = [],
		$description = '',
		$status = 'success',
		$userTokenOrId = null
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$data['accountIdentifier']     = $accountIdentifier;
		$data['currencyCode']          = $currencyCode;
		$data['amount']                = $amount;
		$data['externalTransactionId'] = $externalTransactionId;
		$data['paymentDetails']        = $paymentDetails;
		$data['description']           = $description;
		$data['status']                = $status;

		$response = $this->request('/frontend/billing/externalCreateChargeWithoutProfile', $data);
		return BillingExternalCreateChargeResponse::fromResponse($response);
	}

	/**
	 * Create a charge back for an external charge by using the original transaction ID
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalCreateChargeback
	 * @see https://docs.dislo.com/display/DIS/External+payments+guide
	 *
	 * @param string          $accountIdentifier     the billing account identifier, assigned by dislo staff
	 * @param string          $originalTransactionID external unique id of the original charge
	 * @param string          $description           textual description of the chargeback for support
	 * @param User|int|string $userTokenOrId         User authentication token or user ID.
	 *
	 * @return BillingExternalCreateChargebackResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalCreateChargebackByTransactionId(
		$accountIdentifier,
		$originalTransactionID,
		$description = '',
		$userTokenOrId = null
	) {
		$data = [
			'accountIdentifier'     => $accountIdentifier,
			'externalTransactionId' => $originalTransactionID,
			'description'           => $description,
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/billing/externalCreateChargeback', $data);
		return BillingExternalCreateChargebackResponse::fromResponse($response);
	}

	/**
	 * Create a charge back for an external charge by using the original billing event ID
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalCreateChargeback
	 * @see https://docs.dislo.com/display/DIS/External+payments+guide
	 *
	 * @param string          $accountIdentifier      the billing account identifier, assigned by dislo staff
	 * @param int             $originalBillingEventId ID of the original billing event.
	 * @param string          $description            textual description of the chargeback for support
	 * @param User|int|string $userTokenOrId          User authentication token or user ID.
	 *
	 * @return BillingExternalCreateChargebackResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalCreateChargebackByEventId(
		$accountIdentifier,
		$originalBillingEventId,
		$description = '',
		$userTokenOrId = null
	) {
		$data = [
			'accountIdentifier' => $accountIdentifier,
			'billingEventId'    => $originalBillingEventId,
			'description'       => $description,
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/billing/externalCreateChargeback', $data);
		return BillingExternalCreateChargebackResponse::fromResponse($response);
	}

	/**
	 * Retrieve an external profile by the external id that has been passed in "subscription/externalCreate".
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalGetProfile
	 * @see https://docs.dislo.com/display/DIS/External+payments+guide
	 *
	 * @param string          $externalId    ID for the external profile
	 * @param User|int|string $userTokenOrId User authentication token or user ID.
	 *
	 * @return BillingExternalGetProfileResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalGetProfileByExternalId(
		$externalId,
		$userTokenOrId = null
	) {
		$data = [
			'externalId' => $externalId,
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/billing/externalGetProfile', $data);
		return BillingExternalGetProfileResponse::fromResponse($response);
	}

	/**
	 * Retrieve an external profile by the external id that has been passed in "subscription/externalCreate".
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalGetProfile
	 * @see https://docs.dislo.com/display/DIS/External+payments+guide
	 *
	 * @param Subscription|int $subscription  ID for the subscription expected to have an external profile
	 * @param User|int|string  $userTokenOrId User authentication token or user ID.
	 *
	 * @return BillingExternalGetProfileResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalGetProfileBySubscriptionId(
		$subscription,
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/billing/externalGetProfile', $data);
		return BillingExternalGetProfileResponse::fromResponse($response);
	}

	/**
	 * Create a charge back for an external charge by using the original billing event ID.
	 *
	 * @see https://docs.dislo.com/display/DIS/GetBillingEvent
	 *
	 * @param int             $billingEventId unique id of the billing event
	 * @param User|int|string $userTokenOrId  User authentication token or user ID.
	 *
	 * @return BillingGetEventResponse
	 *
	 * @throws DisloException
	 */
	public function billingGetEvent(
		$billingEventId,
		$userTokenOrId = null
	) {
		$data     = [
			'billingEventId' => $billingEventId,
		];
		$data     = $this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/billing/getBillingEvent', $data);
		return BillingGetEventResponse::fromResponse($response);
	}

	/**
	 * Create a charge back for an external charge by using the original billing event ID.
	 *
	 * @see https://docs.dislo.com/display/DIS/GetBillingEventsForUser
	 *
	 * @param User|int|string $userTokenOrId User authentication token or user ID.
	 *
	 * @param int|null $limit max count of events to fetch, defaults to 10
	 * @param int|null $offset offset starting at 0 from where to fetch limit events
	 * @param string|null $orderDir ASC or DESC defaults to ASC
	 *
	 * @return BillingGetEventsForUserResponse
	 * @throws DisloException
	 * @throws ObjectNotFoundException
	 */
	public function billingGetEventsForUser(
		$userTokenOrId, $limit = 10, $offset = 0, $orderDir = 'ASC'
	) {
		$data = [
			'limit' => $limit,
			'offset' => $offset,
			'orderDir' => $orderDir
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/billing/getBillingEventsForUser', $data);
		return BillingGetEventsForUserResponse::fromResponse($response);
	}

	/**
	 * Get flexible payment method for a user
	 *
	 * @param User|int|string $userTokenOrId User authentication token or user ID.
	 *
	 * @return BillingGetFlexibleResponse
	 *
	 * @throws DisloException
	 */
	public function billingGetFlexible(
		$userTokenOrId
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/billing/getFlexible', $data);
		return BillingGetFlexibleResponse::fromResponse($response);
	}

	/**
	 * Get specific payment method for a user by its identifier
	 *
	 * @param int 			  $flexibleIdentifier
	 * @param User|int|string $userTokenOrId User authentication token or user ID.
	 *
	 * @return BillingGetFlexibleByIdentifierResponse
	 *
	 * @throws DisloException
	 * @throws ObjectNotFoundException
	 */
	public function billingGetFlexibleByIdentifier(
		$flexibleIdentifier,
		$userTokenOrId
	) {
		$data = [
			'flexibleId' => $flexibleIdentifier
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/billing/getFlexibleById', $data);
		return BillingGetFlexibleByIdentifierResponse::fromResponse($response);
	}

	/**
	 * Get active recurring payment method for a subscription
	 *
	 * @param Subscription|int $subscription  ID for the subscription expected to have an external profile
	 * @param User|int|string $userTokenOrId User authentication token or user ID.
	 *
	 * @return BillingGetActiveRecurringResponse
	 *
	 * @throws DisloException
	 */
	public function billingGetActiveRecurring(
		$subscription,
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/billing/getActiveRecurring', $data);
		return BillingGetActiveRecurringResponse::fromResponse($response);
	}

	/**
	 * Close active recurring payment method for a subscription
	 *
	 * @param Subscription|int $subscription  ID for the subscription expected to have an external profile
	 * @param User|int|string $userTokenOrId User authentication token or user ID.
	 *
	 * @return BillingCloseActiveRecurringResponse
	 *
	 * @throws DisloException
	 */
	public function billingCloseActiveRecurring(
		$subscription,
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/billing/closeActiveRecurring', $data);
		return BillingCloseActiveRecurringResponse::fromResponse($response);
	}

	/**
	 * Calculate the price for a subscription addon.
	 *
	 * @see https://docs.dislo.com/display/DIS/CalculateAddonPrice
	 *
	 * @param Subscription|int $subscription
	 * @param string|string[]  $packageIdentifiers
	 * @param string|null      $couponCode
	 * @param User|int|string  $userTokenOrId User authentication token or user ID.
	 *
	 * @return SubscriptionCalculateAddonPriceResponse
	 *
	 * @throws DisloException
	 */
	public function subscriptionCalculateAddonPrice(
		$subscription,
		$packageIdentifiers,
		$couponCode = null,
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId'     =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'packageIdentifiers' => $packageIdentifiers,
			'couponCode'         => $couponCode,
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/calculateAddonPrice', $data);
		return SubscriptionCalculateAddonPriceResponse::fromResponse($response);
	}

	/**
	 * Calculate the price for a potential package change.
	 *
	 * @see https://docs.dislo.com/display/DIS/CalculatePackageChange
	 *
	 * @param Subscription|int $subscription
	 * @param string           $newPackageIdentifier
	 * @param string|null      $couponCode
	 * @param User|string|int  $userTokenOrId User authentication token or user ID.
	 * @param string[]		   $addonPackageIdentifiers
	 *
	 * @return SubscriptionCalculatePackageChangeResponse
	 */
	public function subscriptionCalculatePackageChange(
		$subscription,
		$newPackageIdentifier,
		$couponCode = null,
		$userTokenOrId = null,
		$addonPackageIdentifiers = []
	) {
		$data = [
			'subscriptionId'          =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'newPackageIdentifier'    => $newPackageIdentifier,
			'couponCode'           	  => $couponCode,
			'addonPackageIdentifiers' => $addonPackageIdentifiers
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/calculatePackageChange', $data);
		return SubscriptionCalculatePackageChangeResponse::fromResponse($response);
	}

	/**
	 * Calculates the price for creating a new subscription for an existing user.
	 *
	 * @see https://docs.dislo.com/display/DIS/CalculateSubscriptionPrice
	 *
	 * @param string          $packageIdentifier       the package for the subscription
	 * @param string          $currencyCode            currency which should be used for the user
	 * @param string|null     $couponCode              optional - coupon which should be applied
	 * @param string|string[] $addonPackageIdentifiers optional - additional addon packages
	 * @param User|int|string $userTokenOrId           User authentication token or user ID.
	 *
	 * @return SubscriptionCalculatePriceResponse
	 */
	public function subscriptionCalculatePrice(
		$packageIdentifier,
		$currencyCode,
		$couponCode = null,
		$addonPackageIdentifiers = [],
		$userTokenOrId = null
	) {
		$data = [
			'packageIdentifier'       => $packageIdentifier,
			'currencyCode'            => $currencyCode,
			'couponCode'              => $couponCode,
			'addonPackageIdentifiers' => $addonPackageIdentifiers,
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/calculateSubscriptionPrice', $data);
		return SubscriptionCalculatePriceResponse::fromResponse($response);
	}

	/**
	 * Cancel a future package change
	 *
	 * NOTE: this call only works for package changes which are not applied immediately. In that case you need to call
	 * ChangePackage again.
	 *
	 * @see https://docs.dislo.com/display/DIS/CancelPackageChange
	 *
	 * @param Subscription|int $subscription  the unique subscription id to change
	 * @param User|int|string  $userTokenOrId User authentication token or user ID.
	 *
	 * @return SubscriptionCancelPackageChangeResponse
	 */
	public function subscriptionCancelPackageChange(
		$subscription,
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/cancelPackageChange', $data);
		return SubscriptionCancelPackageChangeResponse::fromResponse($response);
	}

	/**
	 * Cancels a single subscription.
	 *
	 * @param Subscription|int $subscription         the id of the subscription you want to cancel
	 * @param string           $cancelReason         optional - the reason why the user canceled (should be predefined
	 *                                               reasons by your frontend)
	 * @param string           $userCancelReason     optional - a user defined cancellation reason
	 * @param string           $userComments         optional - comments from the user
	 * @param User|int|string  $userTokenOrId        User authentication token or user ID.
	 *
	 * @return SubscriptionCancelResponse
	 */
	public function subscriptionCancel(
		$subscription,
		$cancelReason = '',
		$userCancelReason = '',
		$userComments = '',
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId'   =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'cancelReason'     => $cancelReason,
			'userCancelReason' => $userCancelReason,
			'userComments'     => $userComments,
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/cancel', $data);
		return SubscriptionCancelResponse::fromResponse($response);
	}

	/**
	 * Change the package for a subscription.
	 *
	 * @param Subscription|int $subscription                the unique subscription id to change
	 * @param array            $newPackageIdentifier        the identifier of the new package
	 * @param string[]         $addonPackageIdentifiers     optional - package identifiers of the addons
	 * @param string           $couponCode                  optional - the coupon code to apply
	 * @param array            $metaData                    optional - additional data (if supported by Dislo
	 *                                                      installation)
	 * @param bool             $useFlexible                 use the existing flexible payment method from the user to
	 *                                                      pay for the package change immediately
	 * @param User|int|string  $userTokenOrId               User authentication token or user ID.
	 *
	 * @return SubscriptionChangeResponse
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
		$data = [
			'subscriptionId'       =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'newPackageIdentifier' => $newPackageIdentifier,
		];
		if ($addonPackageIdentifiers) {
			$data['addonPackageIdentifiers'] = $addonPackageIdentifiers;
		}
		if ($couponCode) {
			$data['couponCode'] = $couponCode;
		}
		if ($metaData) {
			$data['metaData'] = $metaData;
		}
		$data['useFlexible'] = $useFlexible;
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/changePackage', $data);
		return SubscriptionChangeResponse::fromResponse($response);
	}

	/**
	 * Check if a coupon code is valid.
	 *
	 * @param string      $couponCode
	 * @param string|null $event @see self::COUPON_EVENT_*
	 *
	 * @return CouponCodeCheckResponse
	 */
	public function couponCodeCheck(
		$couponCode,
		$event = null
	) {
		$data = [
			'couponCode' => $couponCode,
		];
		if ($event) {
			$data['event'] = $event;
		}
		$response = $this->request('/frontend/subscription/checkCouponCode', $data);
		return CouponCodeCheckResponse::fromResponse($response, $couponCode, $event);
	}

	/**
	 * Closes a subscription immediately
	 *
	 * @param Subscription|int $subscription      the id of the subscription you want to close
	 * @param string           $closeReason       optional - the reason why the subscription was closed (should be
	 *                                            predefined reasons by your frontend)
	 * @param User|int|string  $userTokenOrId     User authentication token or user ID.
	 *
	 * @return SubscriptionCloseResponse
	 */
	public function subscriptionClose(
		$subscription,
		$closeReason = '',
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'closeReason'    => $closeReason,
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/close', $data);
		return SubscriptionCloseResponse::fromResponse($response);
	}

	/**
	 * Continues a previously cancelled subscription (undo cancellation).
	 *
	 * @param Subscription|int $subscription  the id of the subscription you want to close
	 * @param User|int|string  $userTokenOrId User authentication token or user ID.
	 *
	 * @return SubscriptionContinueResponse
	 */
	public function subscriptionContinue(
		$subscription,
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/continue', $data);
		return SubscriptionContinueResponse::fromResponse($response);
	}

	/**
	 * Create an addon subscription.
	 *
	 * @param Subscription|int $subscription
	 * @param string[]         $packageIdentifiers
	 * @param string           $couponCode
	 * @param User|int|string  $userTokenOrId User authentication token or user ID.
	 *
	 * @return SubscriptionCloseResponse
	 */
	public function subscriptionCreateAddon(
		$subscription,
		$packageIdentifiers,
		$couponCode = '',
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId'     =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'packageIdentifiers' => $packageIdentifiers,
		];
		if ($couponCode) {
			$data['couponCode'] = $couponCode;
		}
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/createAddonSubscription', $data);
		return SubscriptionCreateAddonResponse::fromResponse($response);
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
	 * @param User|int|string $userTokenOrId User authentication token or user ID.
	 * @param string          $packageIdentifier
	 * @param string          $currencyCode
	 * @param string          $couponCode
	 * @param array           $addonPackageIdentifiers
	 *
	 * @return SubscriptionCreateResponse
	 */
	public function subscriptionCreate(
		$userTokenOrId,
		$packageIdentifier,
		$currencyCode,
		$couponCode = '',
		$addonPackageIdentifiers = []
	) {
		$data = [
			'packageIdentifier' => $packageIdentifier,
			'currencyCode'      => $currencyCode,
		];
		if ($addonPackageIdentifiers) {
			$data['addonPackageIdentifiers'] = $addonPackageIdentifiers;
		}
		if ($couponCode) {
			$data['couponCode'] = $couponCode;
		}
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/create', $data);
		return SubscriptionCreateResponse::fromResponse($response);
	}

	/**
	 * Change the package for an external subscription.
	 *
	 * @param Subscription|int $subscription                the unique subscription id to change
	 * @param string           $newPackageIdentifier        the identifier for the new plan.
	 * @param \DateTime        $newPeriodEnd                end date, has to be >= now.
	 * @param string[]         $addonPackageIdentifiers     optional - package identifiers of the addons
	 * @param null             $newExternalId               if provided, a new external profile will be created for the
	 *                                                      given subscription, the old one is invalidated
	 * @param array            $extraData                   required when newExternalId is set, key value data for
	 *                                                      external profile
	 * @param User|int|string  $userTokenOrId               User authentication token or user ID.
	 *
	 * @return SubscriptionExternalChangeResponse
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
		$newPeriodEnd->setTimezone(new \DateTimeZone('UTC'));
		$data = [
			'subscriptionId'       =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'newPackageIdentifier' => $newPackageIdentifier,
			'newPeriodEnd'         => $newPeriodEnd->format('Y-m-d H:i:s'),
		];
		if ($addonPackageIdentifiers) {
			$data['addonPackageIdentifiers'] = $addonPackageIdentifiers;
		}
		if ($newExternalId) {
			$data['newExternalId'] = $newExternalId;
			$data['extraData']     = $extraData;
		}
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/externalChangePackage', $data);
		return SubscriptionExternalChangeResponse::fromResponse($response);
	}

	/**
	 * Change the period end of an external subscription
	 *
	 * @param Subscription|int $subscription
	 * @param \DateTime        $newPeriodEnd
	 * @param User|int|string  $userTokenOrId User authentication token or user ID.
	 *
	 * @return SubscriptionExternalChangePeriodResponse
	 */
	public function subscriptionExternalChangePeriod(
		$subscription,
		\DateTime $newPeriodEnd,
		$userTokenOrId = null
	) {
		$newPeriodEnd = clone $newPeriodEnd;
		$newPeriodEnd->setTimezone(new \DateTimeZone('UTC'));
		$data = [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'newPeriodEnd'   => $newPeriodEnd->format('Y-m-d H:i:s'),
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/externalChangePeriod', $data);
		return SubscriptionExternalChangePeriodResponse::fromResponse($response);
	}

	/**
	 * Closes an external subscription immediately.
	 *
	 * @param Subscription|int $subscription
	 * @param string           $closeReason
	 * @param User|int|string  $userTokenOrId User authentication token or user ID.
	 *
	 * @return SubscriptionExternalCloseResponse
	 */
	public function subscriptionExternalClose(
		$subscription,
		$closeReason = '',
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
		];
		if ($closeReason) {
			$data['closeReason'] = $closeReason;
		}
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/externalCloseSubscription', $data);
		return SubscriptionExternalCloseResponse::fromResponse($response);
	}

	/**
	 * Create an external addon subscription.
	 *
	 * @param Subscription|int $subscription
	 * @param string[]         $packageIdentifiers
	 * @param User|int|string  $userTokenOrId User authentication token or user ID.
	 *
	 * @return SubscriptionExternalAddonCreateResponse
	 */
	public function subscriptionExternalAddonCreate(
		$subscription,
		$packageIdentifiers,
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId'     =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'packageIdentifiers' => $packageIdentifiers,
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/externalCreateAddonSubscription', $data);
		return SubscriptionExternalAddonCreateResponse::fromResponse($response);
	}

	/**
	 * Create an external subscription.
	 *
	 * @param string          $packageIdentifier            the package for the subscription
	 * @param string          $externalId                   unique id for the external profile that is created for this
	 *                                                      subscription
	 * @param array           $extraData                    key/value array where you can save whatever you need with
	 *                                                      the external profile, you can fetch this later on by
	 *                                                      passing the externalId to "billing/externalGetProfile"
	 * @param string          $currencyCode                 currency which should be used for the user
	 * @param array           $addonPackageIdentifiers      optional - additional addon packages
	 * @param \DateTime|null  $periodEnd                    end of the first period, if omitted, dislo will calculate
	 *                                                      the period end itself by using the package duration
	 * @param User|int|string $userTokenOrId                User authentication token or user ID.
	 *
	 * @return SubscriptionExternalCreateResponse
	 */
	public function subscriptionExternalCreate(
		$packageIdentifier,
		$externalId,
		$extraData,
		$currencyCode,
		$addonPackageIdentifiers = [],
		\DateTime $periodEnd = null,
		$userTokenOrId = null
	) {
		$data = [
			'packageIdentifier'       => $packageIdentifier,
			'externalId'              => $externalId,
			'extraData'               => $extraData,
			'currencyCode'            => $currencyCode,
			'addonPackageIdentifiers' => $addonPackageIdentifiers,
		];
		if ($periodEnd) {
			$periodEnd = clone $periodEnd;
			$periodEnd->setTimezone(new \DateTimeZone('UTC'));
			$data['periodEnd'] = $periodEnd->format(['Y-m-d H:i:s']);
		}
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/externalCreateSubscription', $data);
		return SubscriptionExternalCreateResponse::fromResponse($response);
	}

    /**
     * Call a service provider function related to the subscription. Specific calls depend on the SPI connected to
     * the service behind the subscription.
     *
     * @param User|int|string  $userTokenOrId User authentication token or user ID.
     * @param Subscription|int $subscriptionId
     * @param string           $method
     * @param array            $params
     * @param int|null         $serviceId
     *
     * @return SubscriptionCallSpiResponse
     */
    public function subscriptionCallSpi(
        $userTokenOrId,
        $subscriptionId,
        $method,
        $params,
        $serviceId = null
    ) {
        if ($subscriptionId instanceof Subscription) {
            $subscriptionId = $subscriptionId->getSubscriptionId();
        }
        $data = [
            'subscriptionId' => $subscriptionId,
            'method' => $method,
            'params' => $params,
            'serviceId' => $serviceId
        ];
        $this->userToData($userTokenOrId, $data);
        $response = $this->request('/frontend/subscription/callSpi', $data);
        return SubscriptionCallSpiResponse::fromResponse($response);
    }

	public function subscriptionGetPossibleUpgrades(
		$userTokenOrId,
		$subscriptionId,
		$type = ''
	) {
		$data = [
			'subscriptionId' =>
				($subscriptionId instanceof Subscription?$subscriptionId->getSubscriptionId():$subscriptionId)
		];
		if ($type) {
			$data['type'] = $type;
		}
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/getPossiblePlanChanges', $data);
		return SubscriptionGetPossibleUpgradesResponse::fromResponse($response);
	}

	/**
	 * @param string $packageIdentifier
	 *
	 * @return PackageGetResponse
	 * @throws ObjectNotFoundException
	 */
	public function packageGet(
		$packageIdentifier
	) {
		$packages = $this->packagesList(null)->getPackages();
		foreach ($packages as $package) {
			if ($package->getPackageIdentifier() == $packageIdentifier) {
				return new PackageGetResponse($package);
			}
		}
		throw new ObjectNotFoundException('package with ID ' . $packageIdentifier);
	}

	/**
	 * Retrieve a list of all packages registered in the system.
	 *
	 * @param string|null $serviceIdentifier
	 *
	 * @return PackagesListResponse
	 */
	public function packagesList(
		$serviceIdentifier = null
	) {
		$data = [];
		if ($serviceIdentifier) {
			$data['serviceIdentifier'] = $serviceIdentifier;
		}
		$response = $this->request('/frontend/subscription/getPackages', $data);
		return PackagesListResponse::fromResponse($response);
	}

	/**
	 * Retrieves a single subscription by its id.
	 *
	 * @param Subscription|int $subscription
	 * @param User|int|string  $userTokenOrId User authentication token or user ID.
	 *
	 * @return SubscriptionGetResponse
	 */
	public function subscriptionGet(
		$subscription,
		$userTokenOrId = null
	) {
		$data = [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/get', $data);
		return SubscriptionGetResponse::fromResponse($response);
	}

	/**
	 * Retrieves all subscriptions for a user.
	 *
	 * @param User|int|string $userTokenOrId User authentication token or user ID.
	 *
	 * @return SubscriptionGetAllResponse
	 */
	public function subscriptionGetAll(
		$userTokenOrId
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/getSubscriptions', $data);
		return SubscriptionGetAllResponse::fromResponse($response);
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
	 * @return CouponCodeValidateResponse
	 */
	public function couponCodeValidateNew(
		$couponCode,
		$packageIdentifier,
		$addonPackageIdentifiers = [],
		$currencyCode
	) {
		$data     = [
			'couponCode'              => $couponCode,
			'packageIdentifier'       => $packageIdentifier,
			'addonPackageIdentifiers' => $addonPackageIdentifiers,
			'event'                   => self::COUPON_EVENT_START,
			'currencyCode'            => $currencyCode,
		];
		$response = $this->request('/frontend/subscription/validateCoupon', $data);
		return CouponCodeValidateResponse::fromResponse($response, $couponCode, self::COUPON_EVENT_START);
	}

	/**
	 * Check if a coupon is valid for the given context package/addons/event/user/sub and calculates the discounted
	 * price, for upgrades
	 *
	 * @param string           $couponCode
	 * @param string           $packageIdentifier
	 * @param array            $addonPackageIdentifiers
	 * @param string           $currencyCode
	 * @param User|string|int  $userTokenOrId
	 * @param Subscription|int $subscription
	 *
	 * @return CouponCodeValidateResponse
	 */
	public function couponCodeValidateUpgrade(
		$couponCode,
		$packageIdentifier,
		$addonPackageIdentifiers,
		$currencyCode,
		$subscription,
		$userTokenOrId = null
	) {
		$data = [
			'couponCode'              => $couponCode,
			'packageIdentifier'       => $packageIdentifier,
			'addonPackageIdentifiers' => $addonPackageIdentifiers,
			'event'                   => self::COUPON_EVENT_UPGRADE,
			'currencyCode'            => $currencyCode,
			'subscriptionId'          =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/subscription/validateCoupon', $data);
		return CouponCodeValidateResponse::fromResponse($response, $couponCode, self::COUPON_EVENT_UPGRADE);
	}

    /**
     * Authenticate a user. Returns an access token for subsequent API calls.
     *
     * @param string $username      Username.
     * @param string $password      User password.
     * @param string $ipAddress     IP address of the user attempting to authenticate.
     * @param int    $tokenLifetime Authentication token lifetime in seconds. TokenLifeTime is renewed and extended
     *                              by API calls automatically, using the inital tokenlifetime.
     * @param string $metainfo      Meta information to store with token (4096 bytes)
     * @param bool   $ignoreRateLimit
     *
     * @return UserAuthenticateResponse
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
		$ignoreRateLimit = false
	) {
		$data     = [
			'username'      => $username,
			'password'      => $password,
			'ipAddress'     => $ipAddress,
			'tokenlifetime' => \round($tokenLifetime / 60),
			'metainfo'      => $metainfo,
			'ignoreRateLimit' => $ignoreRateLimit,
		];
		$response = $this->request('/frontend/user/authenticate', $data);

		if (isset($response['error'])) {
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

		return UserAuthenticateResponse::fromResponse($response);
	}

	/**
	 * Deauthenticate a token.
	 *
	 * @param string $authToken
	 *
	 * @return UserDeauthenticateResponse
	 */
	public function userDeauthenticate(
		$authToken
	) {
		$data     = [
			'authToken' => $authToken,
		];
		$response = $this->request('/frontend/user/deAuthToken', $data);
		return UserDeauthenticateResponse::fromResponse($response);
	}

	/**
	 * Change data of an existing user.
	 *
	 * @param User|string|int $userTokenOrId the unique user id to change
	 * @param string          $language      iso-2-letter language key to use for this user
	 * @param string[]        $metaData      meta data for this user (such as first name, last names etc.). NOTE: these
	 *                                       meta data keys must exist in the meta data profile in Distribload
	 *
	 * @return UserChangeResponse
	 */
	public function userChange(
		$userTokenOrId,
		$language,
		$metaData
	) {
		$data = [
			'language' => $language,
			'metaData' => $metaData,
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/user/change', $data);
		return UserChangeResponse::fromResponse($response);
	}

	/**
	 * Change password of an existing user.
	 *
	 * @param User|string|int $userTokenOrId the unique user id to change
	 * @param string          $newPassword   the new password
	 *
	 * @return UserChangeResponse
	 */
	public function userChangePassword(
		$userTokenOrId,
		$newPassword
	) {
		$data = [
			'plaintextPassword' => $newPassword,
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/user/changePassword', $data);
		return UserChangeResponse::fromResponse($response);
	}

	/**
	 * Creates a new user with the given meta data.
	 *
	 * @param string   $language          iso-2-letter language key to use for this user
	 * @param string   $plaintextPassword password for this user
	 * @param string[] $metaData          meta data for this user (such as first name, last names etc.). NOTE: these
	 *                                    meta data keys must exist in the meta data profile in Distribload
	 *
	 * @return UserCreateResponse
	 */
	public function userCreate(
		$language,
		$plaintextPassword,
		$metaData
	) {
		$data     = [
			'language'          => $language,
			'plaintextPassword' => $plaintextPassword,
			'metaData'          => $metaData,
		];
		$response = $this->request('/frontend/user/create', $data);
		return UserCreateResponse::fromResponse($response);
	}

	/**
	 * Soft-delete a user.
	 *
	 * @param User|string|int $userTokenOrId
	 *
	 * @return UserDeleteResponse
	 */
	public function userDelete(
		$userTokenOrId
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/user/delete', $data);
		return UserDeleteResponse::fromResponse($response);
	}

	/**
	 * Disable website login capability for user.
	 *
	 * @param User|string|int $userTokenOrId
	 *
	 * @return UserDisableLoginResponse
	 */
	public function userDisableLogin(
		$userTokenOrId
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/user/disableLogin', $data);
		return UserDisableLoginResponse::fromResponse($response);
	}

	/**
	 * Enable website login capability for user.
	 *
	 * @param User|string|int $userTokenOrId
	 *
	 * @return UserEnableLoginResponse
	 */
	public function userEnableLogin(
		$userTokenOrId
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/user/enableLogin', $data);
		return UserEnableLoginResponse::fromResponse($response);
	}

	/**
	 * Get a user's balance.
	 *
	 * @param User|string|int $userTokenOrId
	 *
	 * @return UserGetBalanceResponse
	 */
	public function userGetBalance(
		$userTokenOrId
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/user/getBalance', $data);
		return UserGetBalanceResponse::fromResponse($response);
	}

	/**
	 * Retrieve a list of metadata elements.
	 *
	 * @return UserGetMetaProfileResponse
	 */
	public function userGetMetaProfile() {
		$data     = [];
		$response = $this->request('/frontend/user/getMetaProfile', $data);
		return UserGetMetaProfileResponse::fromResponse($response);
	}

	/**
	 * Get the status of a Single-Step signup (usually called after the user comes back from the payment provider).
	 *
	 * @param string $signupIdentifier unique signup identifier returned from UserSignupWithPayment
	 *
	 * @return UserGetSignupStatusResponse
	 */
	public function userGetSignupStatus(
		$signupIdentifier
	) {
		$data     = [
			'signupIdentifier' => $signupIdentifier,
		];
		$response = $this->request('/frontend/user/getSignupStatus', $data);
		return UserGetSignupStatusResponse::fromResponse($response);
	}

	/**
	 * Retrieves the users authentication tokens.
	 *
	 * @param User|string|int $userTokenOrId
	 *
	 * @return UserGetTokensResponse
	 */
	public function userGetTokens(
		$userTokenOrId
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/user/getTokens', $data);
		return UserGetTokensResponse::fromResponse($response);
	}

	/**
	 * Retrieves a user.
	 *
	 * @param User|string|int $userTokenOrId
	 *
	 * @return UserGetResponse
	 */
	public function userGet(
		$userTokenOrId
	) {
		$data = [];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/user/get', $data);
		return UserGetResponse::fromResponse($response);
	}

	/**
	 * Update a users AuthToken MetaInfo
	 *
	 * @param string $authToken
	 * @param string $metaInfo
	 * @param string $ipAddress
	 *
	 * @return UserUpdateTokenResponse
	 */
	public function userUpdateToken(
		$authToken,
		$metaInfo,
		$ipAddress = ''
	) {
		$data = [
			'authToken' => $authToken,
			'metaInfo'  => $metaInfo,
		];
		if ($ipAddress) {
			$data['ipAddress'] = $ipAddress;
		}
		$response = $this->request('/frontend/user/updateToken', $data);
		return UserUpdateTokenResponse::fromResponse($response);
	}

	/**
	 * Extend a users AuthToken expiry time
	 *
	 * @param string   $authToken
	 * @param string   $ipAddress
	 * @param int|null $tokenLifetime   Omit to use lifetime set initially
	 *
	 * @return UserUpdateTokenResponse
	 */
	public function userExtendToken(
		$authToken,
		$ipAddress = '',
		$tokenLifetime = null
	) {
		$data = [
			'authToken' => $authToken,
		];
		if ($ipAddress) {
			$data['ipAddress'] = $ipAddress;
		}
		if (isset($tokenLifetime)) {
			$data['tokenlifetime'] = \round($tokenLifetime / 60);
		}
		$response = $this->request('/frontend/user/extendTokenLifeTime', $data);
		return UserUpdateTokenResponse::fromResponse($response);
	}

	/**
	 * Searches among the unique properties of all users in order to find one user. The search term must match exactly.
	 *
	 * @param string $searchTerm
	 *
	 * @return UserFindResponse
	 *
	 * @throws ObjectNotFoundException
	 */
	public function userFind($searchTerm) {
		$response = $this->request('/frontend/user/findUser', ['searchTerm' => $searchTerm]);
		return UserFindResponse::fromResponse($response);
	}


	/**
	 * Start the user recovery process.
	 *
	 * @param string $userIdentifier Unique identifier for the user needing recovery.
	 * @param string $ipAddress      IP address of the request.
	 * @param string $resetLink      Link the user can click to do password recovery. %s will be replaced with the
	 *                               recovery code.
	 *
	 * @return UserRecoveryStartResponse
	 */
	public function userRecoveryStart($userIdentifier, $ipAddress, $resetLink) {
		$response = $this->request('/frontend/user/passwordRecovery/start', [
			'identifier' => $userIdentifier,
			'ipAddress' => $ipAddress,
			'resetLink' => $resetLink
		]);
		return UserRecoveryStartResponse::fromResponse($response);
	}

	/**
	 * Check if a given token is valid.
	 *
	 * @param string $recoveryToken
	 * @param string $ipAddress
	 *
	 * @return UserRecoveryCheckResponse
	 */
	public function userRecoveryCheck($recoveryToken, $ipAddress) {
		$response = $this->request('/frontend/user/passwordRecovery/check', [
			'recoveryToken' => $recoveryToken,
			'ipAddress' => (string)$ipAddress
		]);
		return UserRecoveryCheckResponse::fromResponse($response);
	}

	/**
	 * Finish the account recovery process.
	 *
	 * @param string $recoveryToken
	 * @param string $ipAddress
	 * @param string $newPassword
	 *
	 * @return UserRecoveryFinishResponse
	 *
	 * @throws ObjectNotFoundException
	 */
	public function userRecoveryFinish($recoveryToken, $ipAddress, $newPassword) {
		$response = $this->request('/frontend/user/passwordRecovery/finalize', [
			'recoveryToken' => $recoveryToken,
			'ipAddress' => $ipAddress,
			'plaintextPassword' => $newPassword
		]);
		return UserRecoveryFinishResponse::fromResponse($response);
	}

	/**
	 * Starts the User Verification ProcessWhen using this call, the user will receive an email to his stored email
	 * address which gives instruction on how to verify. The email message must be configured by using the template
	 * "token-verification".
	 *
	 * @param string|int|User $userTokenOrId
	 * @param string          $ipAddress
	 * @param string          $verificationLink
	 *
	 * @return UserEmailVerificationStartResponse
	 */
	public function userEmailVerificationStart(
		$userTokenOrId,
		$ipAddress,
		$verificationLink
	) {
		$data = [
			'verificationLink' => $verificationLink,
			'ipAddress' => (string)$ipAddress,
			'verificationType' => 'email',
		];
		$this->userToData($userTokenOrId, $data);
		$response = $this->request('/frontend/user/verification/start', $data);
		return UserEmailVerificationStartResponse::fromResponse($response);
	}

	/**
	 * Finalizes the users verification Process
	 *
	 * @param $verificationToken
	 *
	 * @return UserEmailVerificationFinishResponse
	 */
	public function userEmailVerificationFinish(
		$verificationToken
	) {
		$data = [
			'verificationToken' => $verificationToken,
			'verificationType' => 'email'
		];
		$response = $this->request('/frontend/user/verification/finalize', $data);
		return UserEmailVerificationFinishResponse::fromResponse($response);

	}

    /**
     * @param string|int|User $userTokenOrId
     * @param string          $ipAddress
     * @param string          $phoneNumber
     *
     * @return UserPhoneVerificationStartResponse
     */
    public function userPhoneVerificationStart(
        $userTokenOrId,
        $ipAddress,
        $phoneNumber
    ) {
        $data = [
            'verificationType' => 'phone',
            'ipAddress' => (string)$ipAddress,
            'extraData' => [
                'phoneNumber' => $phoneNumber
            ]
        ];
        $this->userToData($userTokenOrId, $data);
        $response = $this->request('/frontend/user/verification/start', $data);
        return UserPhoneVerificationStartResponse::fromResponse($response);
    }

    /**
     * @param string|int|User $userTokenOrId
     * @param string          $verificationPin
	 * @param string|null	  $phoneNumber
     *
     * @return UserPhoneVerificationFinishResponse
     */
    public function userPhoneVerificationFinish(
        $userTokenOrId,
        $verificationPin,
		$phoneNumber = null
    ) {
        $data = [
            'verificationType' => 'phone',
            'verificationPin' => $verificationPin,
			'phoneNumber' => $phoneNumber,
        ];
        $this->userToData($userTokenOrId, $data);
        $response = $this->request('/frontend/user/verification/finalize', $data);
        return UserPhoneVerificationFinishResponse::fromResponse($response);
    }

    /**
     * @param string|int|User $userTokenOdId
     * @param string          $ipAddress
     * @param string          $phoneNumber
     *
     * @return UserVerificationStartResponse
     */
    public function userSmsVerificationStart(
        $userTokenOdId,
        $ipAddress,
        $phoneNumber
    ) {
        $data = [
            'verificationType' => 'sms',
            'ipAddress' => (string)$ipAddress,
            'extraData' => [
                'phoneNumber' => $phoneNumber
            ]
        ];
        $this->userToData($userTokenOdId, $data);
        $response = $this->request('/frontend/user/verification/start', $data);
        return UserSmsVerificationStartResponse::fromResponse($response);
    }

    /**
     * @param string|int|User $userTokenOrId
     * @param string          $verificationPin
	 * @param string|null	  $phoneNumber
     *
     * @return UserSmsVerificationFinishResponse
     */
    public function userSmsVerificationFinish(
        $userTokenOrId,
        $verificationPin,
		$phoneNumber = null
    ) {
        $data = [
            'verificationType' => 'sms',
            'verificationPin' => $verificationPin,
			'phoneNumber' => $phoneNumber,
        ];
        $this->userToData($userTokenOrId, $data);
        $response = $this->request('/frontend/user/verification/finalize', $data);
        return UserSmsVerificationFinishResponse::fromResponse($response);
    }

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
	public function exportStreamReport(
		$reportId,
		$parameters = null,
		$stream = null
	) {
    	$data = [];
		if ($parameters) {
			$data['parameters'] = $parameters;
		}
		if (!$stream) {
			$stream = \fopen('php://stdout', 'w');
		}
		return $this->getRequestClientExtra()->requestStream('/export/v2/report/' . $reportId, $data, $stream);
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
	public function exportStreamQuery(
		$query,
		$parameters = null,
		$stream = null
	) {
		$data = [
			'query' => $query
		];
		if ($parameters) {
			$data['parameters'] = $parameters;
		}
		if (!$stream) {
			$stream = \fopen('php://stdout', 'w');
		}
		return $this->getRequestClientExtra()->requestStream('/export/v2/query', $data, $stream);
	}
}
