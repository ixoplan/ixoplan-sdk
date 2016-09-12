<?php

namespace Ixolit\Dislo;

use Ixolit\Dislo\Request\CDERequestClient;
use Ixolit\Dislo\Request\RequestClient;
use Ixolit\Dislo\Response\BillingCloseFlexibleResponse;
use Ixolit\Dislo\Response\BillingCreateFlexibleResponse;
use Ixolit\Dislo\Response\BillingCreatePaymentResponse;
use Ixolit\Dislo\Response\BillingExternalCreateChargeResponse;
use Ixolit\Dislo\WorkingObjects\Flexible;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjects\User;

/**
 * The main client class for use with the Dislo API. Requires a RequestClient class as a parameter when not running
 * inside the CDE. (e.g. HTTPRequestClient
 */
class Client {
	/**
	 * @var RequestClient
	 */
	private $requestClient;

	/**
	 * @param RequestClient|null $requestClient Required when not running in the CDE.
	 *
	 * @throws \Exception
	 */
	public function __construct(RequestClient $requestClient = null) {
		if (!$requestClient) {
			if (\function_exists('\\apiCall')) {
				$requestClient = new CDERequestClient();
			} else {
				throw new \Exception('A RequestClient parameter is required when not running in the CDE!');
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
	 */
	public function billingCloseFlexible($user, $flexible) {
		$response = $this->requestClient->request('/frontend/billing/closeFlexible', [
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
		$response = $this->requestClient->request('/frontend/billing/createFlexible', $data);
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
	 * @param User|int         $user
	 * @param Subscription|int $subscription
	 * @param string           $billingMethod
	 * @param string           $returnUrl
	 * @param array            $paymentDetails
	 *
	 * @return BillingCreatePaymentResponse
	 */
	public function billingCreatePayment($user, $subscription, $billingMethod, $returnUrl, $paymentDetails) {
		$response = $this->requestClient->request('/frontend/billing/createPayment', [
			'userId'         => ($user instanceof User ? $user->getUserId() : (int)$user),
			'billingMethod'  => $billingMethod,
			'returnUrl'      => $returnUrl,
			'subscriptionId' =>
				($subscription instanceof Subscription ? $subscription->getSubscriptionId() : $subscription),
			'paymentDetails' => $paymentDetails,
		]);
		return BillingCreatePaymentResponse::fromResponse($response);
	}

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
		$response = $this->requestClient->request('/frontend/billing/externalCreateCharge', [
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
}
