<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class SubscriptionExternalCloseResponse
 *
 * @package Ixolit\Dislo\Response
 */
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

    /**
     * @param array $response
     *
     * @return SubscriptionExternalCloseResponse
     */
	public static function fromResponse($response) {
		return new SubscriptionExternalCloseResponse(Subscription::fromResponse($response['subscription']));
	}
}