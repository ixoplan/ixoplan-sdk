<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;

/**
 * Class CouponCodeValidateResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\CouponCodeValidateResponseObject instead
 */
class CouponCodeValidateResponse extends CouponCodeResponse {
	/**
	 * @var Price
	 */
	private $discountedPrice;

	/** @var Price|null */
	private $recurringPrice;

	/**
	 * @param bool   	 $valid
	 * @param string 	 $reason
	 * @param string 	 $couponCode
	 * @param string 	 $event
	 * @param Price 	 $discountedPrice
	 * @param Price|null $recurringPrice
	 */
	public function __construct($valid, $reason, $couponCode, $event, Price $discountedPrice, Price $recurringPrice = null) {
		parent::__construct($valid, $reason, $couponCode, $event);
		$this->discountedPrice = $discountedPrice;
		$this->recurringPrice = $recurringPrice;
	}

	/**
	 * @return Price
	 */
	public function getDiscountedPrice() {
		return $this->discountedPrice;
	}

	/**
	 * @return Price|null
	 */
	public function getRecurringPrice() {
		return $this->recurringPrice;
	}

	public static function fromResponse($response, $couponCode, $event) {
		return new CouponCodeValidateResponse(
			$response['valid'],
			$response['reason'],
			$couponCode,
			$event,
			Price::fromResponse($response['discountedPrice']),
			Price::fromResponse($response['recurringPrice'])
		);
	}
}
