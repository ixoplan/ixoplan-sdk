<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Subscription;

class SubscriptionChangeResponse {
	/**
	 * @var Subscription
	 */
	private $subscription;
	/**
	 * @var bool
	 */
	private $needsBilling;
	/**
	 * @var Price
	 */
	private $price;

	/**
	 * @var bool
	 */
	private $appliedImmediately;

	/**
	 * @param Subscription $subscription
	 * @param bool         $needsBilling
	 * @param Price        $price
	 * @param bool         $appliedImmediately
	 */
	public function __construct(Subscription $subscription, $needsBilling, Price $price, $appliedImmediately) {
		$this->subscription       = $subscription;
		$this->needsBilling       = $needsBilling;
		$this->price              = $price;
		$this->appliedImmediately = $appliedImmediately;
	}

	/**
	 * @return Subscription
	 */
	public function getSubscription() {
		return $this->subscription;
	}

	/**
	 * @return boolean
	 */
	public function isNeedsBilling() {
		return $this->needsBilling;
	}

	/**
	 * @return Price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @return boolean
	 */
	public function isAppliedImmediately() {
		return $this->appliedImmediately;
	}

	/**
	 * @param array $response
	 *
	 * @return SubscriptionChangeResponse
	 */
	public static function fromResponse($response) {
		return new SubscriptionChangeResponse(
			Subscription::fromResponse($response['subscription']),
			$response['needsBilling'],
			Price::fromResponse($response['price']),
			$response['appliedImmediately']
		);
	}
}