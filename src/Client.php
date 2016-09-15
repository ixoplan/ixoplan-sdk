<?php

namespace Ixolit\Dislo;

use Ixolit\Dislo\Exceptions\DisloException;
use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\Request\CDERequestClient;
use Ixolit\Dislo\Request\RequestClient;
use Ixolit\Dislo\Response\BillingCloseFlexibleResponse;
use Ixolit\Dislo\Response\BillingCreateFlexibleResponse;
use Ixolit\Dislo\Response\BillingCreatePaymentResponse;
use Ixolit\Dislo\Response\BillingExternalCreateChargebackResponse;
use Ixolit\Dislo\Response\BillingExternalCreateChargeResponse;
use Ixolit\Dislo\Response\BillingExternalGetProfileResponse;
use Ixolit\Dislo\Response\BillingGetEventResponse;
use Ixolit\Dislo\Response\BillingGetEventsForUserResponse;
use Ixolit\Dislo\Response\BillingGetFlexibleResponse;
use Ixolit\Dislo\Response\SubscriptionCalculateAddonPriceResponse;
use Ixolit\Dislo\Response\SubscriptionCalculatePackageChangeResponse;
use Ixolit\Dislo\Response\SubscriptionCalculatePriceResponse;
use Ixolit\Dislo\Response\SubscriptionCancelPackageChangeResponse;
use Ixolit\Dislo\Response\SubscriptionCancelResponse;
use Ixolit\Dislo\WorkingObjects\Flexible;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjects\User;

/**
 * The main client class for use with the Dislo API. Requires a RequestClient class as a parameter when not running
 * inside the CDE. (e.g. HTTPRequestClient).
 *
 * For details about the Dislo API, the available calls and Dislo itself please read the documentation available at
 * https://docs.dislo.com/
 */
class Client {
	/**
	 * @var RequestClient
	 */
	private $requestClient;

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
				switch ($response['code']) {
					case 404:
						throw new ObjectNotFoundException($response['message'], $response['code']);
					default:
						throw new DisloException($response['message'], $response['code']);
				}
			} else {
				return $response;
			}
		} catch (\Exception $e) {
			throw new DisloException($e->getMessage(), $e->getCode(), $e);
		}
	}

	/**
	 * Initialize the client with a RequestClient, the class that is responsible for transporting messages to and
	 * from the Dislo API. If no RequestClient is passed, this class attempts to use the CDE-internal API method.
	 *
	 * @param RequestClient|null $requestClient Required when not running in the CDE.
	 *
	 * @throws DisloException if the $requestClient parameter is missing
	 */
	public function __construct(RequestClient $requestClient = null) {
		if (!$requestClient) {
			if (\function_exists('\\apiCall')) {
				$requestClient = new CDERequestClient();
			} else {
				throw new DisloException('A RequestClient parameter is required when not running in the CDE!');
			}
		}
		$this->requestClient = $requestClient;
	}

	/**
	 * Closes the flexible payment method for a user.
	 *
	 * Note: once you close an active flexible, subscriptions cannot get extended automatically!
	 *
	 * @see https://docs.dislo.com/display/DIS/CloseFlexible
	 *
	 * @param User|int     $user
	 * @param Flexible|int $flexible
	 *
	 * @return BillingCloseFlexibleResponse
	 *
	 * @throws DisloException
	 */
	public function billingCloseFlexible($user, $flexible) {
		$response = $this->request('/frontend/billing/closeFlexible', [
			'userId'     => ($user instanceof User ? $user->getUserId() : (int)$user),
			'flexibleId' => ($flexible instanceof Flexible ? $flexible->getFlexibleId() : (int)$flexible),
		]);
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
	 * @param User|int $user
	 * @param string   $billingMethod
	 * @param string   $returnUrl
	 * @param array    $paymentDetails
	 * @param string   $currencyCode
	 *
	 * @return BillingCreateFlexibleResponse
	 *
	 * @throws DisloException
	 */
	public function billingCreateFlexible($user, $billingMethod, $returnUrl, $paymentDetails, $currencyCode = '') {
		$data = [
			'userId'         => ($user instanceof User ? $user->getUserId() : (int)$user),
			'billingMethod'  => $billingMethod,
			'returnUrl'      => $returnUrl,
			'paymentDetails' => $paymentDetails,
		];
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
	 * @param User|int         $user
	 * @param Subscription|int $subscription
	 * @param string           $billingMethod
	 * @param string           $returnUrl
	 * @param array            $paymentDetails
	 *
	 * @return BillingCreatePaymentResponse
	 *
	 * @throws DisloException
	 */
	public function billingCreatePayment($user, $subscription, $billingMethod, $returnUrl, $paymentDetails) {
		$response = $this->request('/frontend/billing/createPayment', [
			'userId'         => ($user instanceof User ? $user->getUserId() : (int)$user),
			'billingMethod'  => $billingMethod,
			'returnUrl'      => $returnUrl,
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'paymentDetails' => $paymentDetails,
		]);
		return BillingCreatePaymentResponse::fromResponse($response);
	}

	/**
	 * Create an external charge.
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalCreateCharge
	 * @see https://docs.dislo.com/display/DIS/External+payments+guide
	 *
	 * @param User|int $user                  unique user id
	 * @param string   $externalProfileId     the external profile to which the charge should be linked, this is the
	 *                                        "externalId" you passed in the "subscription/externalCreate" call
	 * @param string   $accountIdentifier     the billing account identifier, you will this from dislo staff
	 * @param string   $currencyCode          currency code EUR, USD, ...
	 * @param float    $amount                the amount of the charge
	 * @param string   $externalTransactionId external unique id for the charge
	 * @param int|null $upgradeId             the unique upgrade id to which the charge should be linked, you get this
	 *                                        from the
	 *                                        "subscription/externalChangePackage" or
	 *                                        "subscription/externalCreateAddonSubscription" call
	 * @param array    $paymentDetails        additional data you want to save with the charge
	 * @param string   $description           description of the charge
	 * @param string   $status                status the charge should be created with, you might want to log erroneous
	 *                                        charges in dislo too, but you don't have to. @see BillingEvent::STATUS_*
	 *
	 * @return BillingExternalCreateChargeResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalCreateCharge(
		$user,
		$externalProfileId,
		$accountIdentifier,
		$currencyCode,
		$amount,
		$externalTransactionId,
		$upgradeId = null,
		array $paymentDetails = [],
		$description = '',
		$status = 'success'
	) {
		$response = $this->request('/frontend/billing/externalCreateCharge', [
			'userId'                => ($user instanceof User ? $user->getUserId() : (int)$user),
			'externalProfileId'     => $externalProfileId,
			'accountIdentifier'     => $accountIdentifier,
			'currencyCode'          => $currencyCode,
			'amount'                => $amount,
			'externalTransactionId' => $externalTransactionId,
			'upgradeId'             => $upgradeId,
			'paymentDetails'        => $paymentDetails,
			'description'           => $description,
			'status'                => $status,
		]);
		return BillingExternalCreateChargeResponse::fromResponse($response);
	}

	/**
	 * Create a charge back for an external charge by using the original transaction ID
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalCreateChargeback
	 * @see https://docs.dislo.com/display/DIS/External+payments+guide
	 *
	 * @param string $accountIdentifier     the billing account identifier, assigned by dislo staff
	 * @param string $originalTransactionID external unique id of the original charge
	 * @param string $description           textual description of the chargeback for support
	 *
	 * @return BillingExternalCreateChargebackResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalCreateChargebackByTransactionId(
		$accountIdentifier,
		$originalTransactionID,
		$description = ''
	) {
		$response = $this->request('/frontend/billing/externalCreateChargeback', [
			'accountIdentifier'     => $accountIdentifier,
			'externalTransactionId' => $originalTransactionID,
			'description'           => $description,
		]);
		return BillingExternalCreateChargebackResponse::fromResponse($response);
	}

	/**
	 * Create a charge back for an external charge by using the original billing event ID
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalCreateChargeback
	 * @see https://docs.dislo.com/display/DIS/External+payments+guide
	 *
	 * @param string $accountIdentifier      the billing account identifier, assigned by dislo staff
	 * @param int    $originalBillingEventId ID of the original billing event.
	 * @param string $description            textual description of the chargeback for support
	 *
	 * @return BillingExternalCreateChargebackResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalCreateChargebackByEventId(
		$accountIdentifier,
		$originalBillingEventId,
		$description = ''
	) {
		$response = $this->request('/frontend/billing/externalCreateChargeback', [
			'accountIdentifier' => $accountIdentifier,
			'billingEventId'    => $originalBillingEventId,
			'description'       => $description,
		]);
		return BillingExternalCreateChargebackResponse::fromResponse($response);
	}

	/**
	 * Retrieve an external profile by the external id that has been passed in "subscription/externalCreate".
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalGetProfile
	 * @see https://docs.dislo.com/display/DIS/External+payments+guide
	 *
	 * @param string $externalId ID for the external profile
	 *
	 * @return BillingExternalGetProfileResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalGetProfileByExternalId(
		$externalId
	) {
		$response = $this->request('/frontend/billing/externalGetProfile', [
			'externalId' => $externalId,
		]);
		return BillingExternalGetProfileResponse::fromResponse($response);
	}

	/**
	 * Retrieve an external profile by the external id that has been passed in "subscription/externalCreate".
	 *
	 * @see https://docs.dislo.com/display/DIS/ExternalGetProfile
	 * @see https://docs.dislo.com/display/DIS/External+payments+guide
	 *
	 * @param Subscription|int $subscription ID for the subscription expected to have an external profile
	 *
	 * @return BillingExternalGetProfileResponse
	 *
	 * @throws DisloException
	 */
	public function billingExternalGetProfileBySubscriptionId(
		$subscription
	) {
		$response = $this->request('/frontend/billing/externalGetProfile', [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
		]);
		return BillingExternalGetProfileResponse::fromResponse($response);
	}

	/**
	 * Create a charge back for an external charge by using the original billing event ID.
	 *
	 * @see https://docs.dislo.com/display/DIS/GetBillingEvent
	 *
	 * @param int $billingEventId unique id of the billing event
	 *
	 * @return BillingGetEventResponse
	 *
	 * @throws DisloException
	 */
	public function billingGetEvent(
		$billingEventId
	) {
		$response = $this->request('/frontend/billing/getBillingEvent', [
			'billingEventId' => $billingEventId,
		]);
		return BillingGetEventResponse::fromResponse($response);
	}

	/**
	 * Create a charge back for an external charge by using the original billing event ID.
	 *
	 * @see https://docs.dislo.com/display/DIS/GetBillingEventsForUser
	 *
	 * @param User|int $user User or user ID to get billing events for.
	 *
	 * @return BillingGetEventsForUserResponse
	 *
	 * @throws DisloException
	 */
	public function billingGetEventsForUser(
		$user
	) {
		$response = $this->request('/frontend/billing/getBillingEventsForUser', [
			'userId' => ($user instanceof User ? $user->getUserId() : $user),
		]);
		return BillingGetEventsForUserResponse::fromResponse($response);
	}

	/**
	 * Get flexible payment method for a user
	 *
	 * @param User|int $user User or user ID to get billing events for.
	 *
	 * @return BillingGetFlexibleResponse
	 *
	 * @throws DisloException
	 */
	public function billingGetFlexible($user) {
		$response = $this->request('/frontend/billing/getBillingEventsForUser', [
			'userId' => ($user instanceof User ? $user->getUserId() : $user),
		]);
		return BillingGetFlexibleResponse::fromResponse($response);
	}

	/**
	 * Calculate the price for a subscription addon.
	 *
	 * @see https://docs.dislo.com/display/DIS/CalculateAddonPrice
	 *
	 * @param User|int         $user
	 * @param Subscription|int $subscription
	 * @param string|string[]  $packageIdentifiers
	 * @param string|null      $couponCode
	 *
	 * @return SubscriptionCalculateAddonPriceResponse
	 *
	 * @throws DisloException
	 */
	public function subscriptionCalculateAddonPrice($user, $subscription, $packageIdentifiers, $couponCode = null) {
		$response = $this->request('/frontend/subscription/calculateAddonPrice', [
			'userId'             => ($user instanceof User ? $user->getUserId() : $user),
			'subscriptionId'     =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'packageIdentifiers' => $packageIdentifiers,
			'couponCode'         => $couponCode,
		]);
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
	 *
	 * @return SubscriptionCalculatePackageChangeResponse
	 *
	 * @throws DisloException
	 */
	public function subscriptionCalculatePackageChange($subscription, $newPackageIdentifier, $couponCode = null) {
		$response = $this->request('/frontend/subscription/calculatePackageChange', [
			'subscriptionId'       =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'newPackageIdentifier' => $newPackageIdentifier,
			'couponCode'           => $couponCode,
		]);
		return SubscriptionCalculatePackageChangeResponse::fromResponse($response);
	}

	/**
	 * Calculates the price for creating a new subscription for an existing user.
	 *
	 * @see https://docs.dislo.com/display/DIS/CalculateSubscriptionPrice
	 *
	 * @param User|int        $user                    the unique user id for which the subscription is created
	 * @param string          $packageIdentifier       the package for the subscription
	 * @param string          $currencyCode            currency which should be used for the user
	 * @param string|null     $couponCode              optional - coupon which should be applied
	 * @param string|string[] $addonPackageIdentifiers optional - additional addon packages
	 *
	 * @return SubscriptionCalculatePriceResponse
	 */
	public function subscriptionCalculatePrice(
		$user, $packageIdentifier, $currencyCode, $couponCode = null,
		$addonPackageIdentifiers = []
	) {
		$response = $this->request('/frontend/subscription/calculateSubscriptionPrice', [
			'userId'                  =>
				($user instanceof User ? $user->getUserId() : $user),
			'packageIdentifier'       => $packageIdentifier,
			'currencyCode'            => $currencyCode,
			'couponCode'              => $couponCode,
			'addonPackageIdentifiers' => $addonPackageIdentifiers,
		]);
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
	 * @param Subscription|int $subscription the unique subscription id to change
	 *
	 * @return SubscriptionCancelPackageChangeResponse
	 */
	public function subscriptionCancelPackageChange(
		$subscription
	) {
		$response = $this->request('/frontend/subscription/cancelPackageChange', [
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
		]);
		return SubscriptionCancelPackageChangeResponse::fromResponse($response);
	}

	/**
	 * Cancels a single subscription.
	 *
	 * @param Subscription|int $subscription     the id of the subscription you want to cancel
	 * @param string           $cancelReason     optional - the reason why the user canceled (should be predefined
	 *                                           reasons by your frontend)
	 * @param string           $userCancelReason optional - a user defined cancellation reason
	 * @param string           $userComments     optional - comments from the user
	 *
	 * @return SubscriptionCancelResponse
	 */
	public function subscriptionCancel(
		$subscription,
		$cancelReason = '',
		$userCancelReason = '',
		$userComments = ''
	) {
		$response = $this->request('/frontend/subscription/cancelPackageChange', [
			'subscriptionId'   =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'cancelReason'     => $cancelReason,
			'userCancelReason' => $userCancelReason,
			'userComments'     => $userComments,
		]);
		return SubscriptionCancelResponse::fromResponse($response);
	}
}
