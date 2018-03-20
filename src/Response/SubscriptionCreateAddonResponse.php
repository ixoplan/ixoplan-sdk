<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class SubscriptionCreateAddonResponse
 *
 * @package Ixolit\Dislo\Response
 */
class SubscriptionCreateAddonResponse {

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
	 * @param Subscription $subscription
	 * @param bool         $needsBilling
	 * @param Price        $price
	 */
	public function __construct(Subscription $subscription, $needsBilling, Price $price) {
		$this->subscription = $subscription;
		$this->needsBilling = $needsBilling;
		$this->price        = $price;
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
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return new self(
			Subscription::fromResponse($response['subscription']),
			$response['needsBilling'],
			Price::fromResponse($response['price'])
		);
	}
}