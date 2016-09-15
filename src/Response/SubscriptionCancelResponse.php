<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Subscription;

class SubscriptionCancelResponse {
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
	 * @return SubscriptionCancelResponse
	 */
	public static function fromResponse($response) {
		return new SubscriptionCancelResponse(
			Subscription::fromResponse($response['subscription'])
		);
	}
}