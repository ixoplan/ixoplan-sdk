<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class SubscriptionExternalChangePeriodResponse
 *
 * @package Ixolit\Dislo\Response
 */
class SubscriptionExternalChangePeriodResponse {

	/**
	 * @var Subscription
	 */
	private $subscription;

	/**
	 * @param Subscription $subscription
	 */
	public function __construct(Subscription $subscription) {
		$this->subscription = $subscription;
	}

	/**
	 * @return Subscription
	 */
	public function getSubscription() {
		return $this->subscription;
	}

    /**
     * @param array $response
     *
     * @return SubscriptionExternalChangePeriodResponse
     */
	public static function fromResponse($response) {
		return new SubscriptionExternalChangePeriodResponse(Subscription::fromResponse($response['subscription']));
	}
}