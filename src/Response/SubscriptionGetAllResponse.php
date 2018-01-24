<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class SubscriptionGetAllResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\SubscriptionGetAllResponseObject instead
 */
class SubscriptionGetAllResponse {
	/**
	 * @var Subscription[]
	 */
	private $subscriptions;

	/**
	 * @param \Ixolit\Dislo\WorkingObjects\Subscription[] $subscriptions
	 */
	public function __construct(array $subscriptions) {
		$this->subscriptions = $subscriptions;
	}

	/**
	 * @return \Ixolit\Dislo\WorkingObjects\Subscription[]
	 */
	public function getSubscriptions() {
		return $this->subscriptions;
	}

	public static function fromResponse($response) {
		$subscriptions = [];

		foreach ($response['subscriptions'] as $subscriptionDefinition) {
			$subscriptions[] = Subscription::fromResponse($subscriptionDefinition);
		}

		return new SubscriptionGetAllResponse($subscriptions);
	}
}