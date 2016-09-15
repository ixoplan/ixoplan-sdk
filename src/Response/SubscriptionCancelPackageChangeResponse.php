<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Subscription;

class SubscriptionCancelPackageChangeResponse {
	/**
	 * @var Subscription[]
	 */
	private $subscriptions;

	/**
	 * @param Subscription[] $subscriptions
	 */
	public function __construct($subscriptions) {
		$this->subscriptions = $subscriptions;
	}

	/**
	 * @return Subscription[]
	 */
	public function getSubscriptions() {
		return $this->subscriptions;
	}

	/**
	 * @param array $response
	 *
	 * @return SubscriptionCancelPackageChangeResponse
	 */
	public static function fromResponse($response) {
		$subscriptions = [];
		foreach ($response['subscriptions'] as $subscriptionData) {
			$subscriptions[] = Subscription::fromResponse($subscriptionData);
		}
		return new SubscriptionCancelPackageChangeResponse($subscriptions);
	}
}
