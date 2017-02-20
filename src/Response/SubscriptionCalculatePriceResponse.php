<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;

class SubscriptionCalculatePriceResponse {
	/**
	 * @var Price
	 */
	private $price;

	/** @var Price|null */
	private $recurringPrice;

	/**
	 * SubscriptionCalculateAddonPriceResponse constructor.
	 *
	 * @param Price $price
	 * @param Price $recurringPrice
	 */
	public function __construct(Price $price, Price $recurringPrice = null) {
		$this->price          = $price;
		$this->recurringPrice = $recurringPrice;
	}

	/**
	 * @return Price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @return Price|null
	 */
	public function getRecurringPrice() {
		return $this->recurringPrice;
	}

	/**
	 * @param array $response
	 *
	 * @return SubscriptionCalculatePriceResponse
	 */
	public static function fromResponse($response) {
		return new SubscriptionCalculatePriceResponse(
			Price::fromResponse($response['price']),
			isset($response['recurringPrice']) ? Price::fromResponse($response['recurringPrice']) : null
		);
	}
}