<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;

class SubscriptionCalculateAddonPriceResponse {
	/**
	 * @var bool
	 */
	private $needsBilling;

	/**
	 * @var Price
	 */
	private $price;

	/**
	 * SubscriptionCalculateAddonPriceResponse constructor.
	 *
	 * @param bool  $needsBilling
	 * @param Price $price
	 */
	public function __construct($needsBilling, Price $price) {
		$this->needsBilling = $needsBilling;
		$this->price        = $price;
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
	 * @return SubscriptionCalculateAddonPriceResponse
	 */
	public static function fromResponse(array $response) {
		return new SubscriptionCalculateAddonPriceResponse(
			$response['needsBilling'],
			Price::fromResponse($response['price'])
		);
	}
}