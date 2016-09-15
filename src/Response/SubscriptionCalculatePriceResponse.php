<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;

class SubscriptionCalculatePriceResponse {
	/**
	 * @var Price
	 */
	private $price;

	/**
	 * SubscriptionCalculateAddonPriceResponse constructor.
	 *
	 * @param Price $price
	 */
	public function __construct(Price $price) {
		$this->price        = $price;
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
	 * @return SubscriptionCalculatePriceResponse
	 */
	public static function fromResponse(array $response) {
		return new SubscriptionCalculatePriceResponse(
			Price::fromResponse($response['price'])
		);
	}
}