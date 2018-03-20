<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class SubscriptionCloseResponse
 *
 * @package Ixolit\Dislo\Response
 */
class SubscriptionCloseResponse {

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
	 * @return SubscriptionCloseResponse
	 */
	public static function fromResponse($response) {
		return new SubscriptionCloseResponse(Subscription::fromResponse($response['subscription']));
	}
}