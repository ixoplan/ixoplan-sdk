<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Subscription;

class SubscriptionCreateResponse {
	/**
	 * @var bool
	 */
	private $needsBilling;

	/**
	 * @var Price
	 */
	private $price;

	/**
	 * @var Subscription
	 */
	private $subscription;

	/**
	 * @param bool         $needsBilling
	 * @param Price        $price
	 * @param Subscription $subscription
	 */
	public function __construct($needsBilling, Price $price, Subscription $subscription) {
		$this->needsBilling = $needsBilling;
		$this->price        = $price;
		$this->subscription = $subscription;
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
	 * @return Subscription
	 */
	public function getSubscription() {
		return $this->subscription;
	}

	public static function fromResponse($response) {
		return new SubscriptionCreateResponse(
			$response['needsBilling'],
			Price::fromResponse($response['price']),
			Subscription::fromResponse($response['subscription'])
		);
	}
}