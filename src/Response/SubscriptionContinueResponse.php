<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class SubscriptionContinueResponse
 *
 * @package Ixolit\Dislo\Response
 */
class SubscriptionContinueResponse {

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
	 * @return SubscriptionContinueResponse
	 */
	public static function fromResponse($response) {
		return new SubscriptionContinueResponse(Subscription::fromResponse($response['subscription']));
	}
}