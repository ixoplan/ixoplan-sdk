<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Subscription;

class SubscriptionGetResponse {
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
		return new SubscriptionGetResponse(Subscription::fromResponse($response['subscription']));
	}
}