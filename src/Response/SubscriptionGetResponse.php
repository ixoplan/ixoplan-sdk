<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class SubscriptionGetResponse
 *
 * @package Ixolit\Dislo\Response
 */
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

    /**
     * @param array $response
     *
     * @return SubscriptionGetResponse
     */
	public static function fromResponse($response) {
		return new SubscriptionGetResponse(Subscription::fromResponse($response['subscription']));
	}
}