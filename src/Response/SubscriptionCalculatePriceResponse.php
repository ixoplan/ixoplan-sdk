<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;

/**
 * Class SubscriptionCalculatePriceResponse
 *
 * @package Ixolit\Dislo\Response
 */
class SubscriptionCalculatePriceResponse extends SubscriptionPriceResponse {

	/**
	 * SubscriptionCalculateAddonPriceResponse constructor.
	 *
	 * @param Price $price
	 * @param Price $recurringPrice
	 */
	public function __construct(Price $price, Price $recurringPrice = null) {
		parent::__construct($price, $recurringPrice);
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