<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Subscription;

class SubscriptionExternalCloseResponse {
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

	public static function fromResponse($response) {
		return new SubscriptionExternalCloseResponse(Subscription::fromResponse($response['subscription']));
	}
}