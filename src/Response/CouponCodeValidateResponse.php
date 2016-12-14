<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;

class CouponCodeValidateResponse extends CouponCodeResponse {
	/**
	 * @var Price
	 */
	private $discountedPrice;

	/**
	 * @param bool   $valid
	 * @param string $reason
	 * @param string $couponCode
	 * @param string $event
	 * @param Price  $discountedPrice
	 */
	public function __construct($valid, $reason, $couponCode, $event, Price $discountedPrice) {
		parent::__construct($valid, $reason, $couponCode, $event);
		$this->discountedPrice = $discountedPrice;
	}

	/**
	 * @return Price
	 */
	public function getDiscountedPrice() {
		return $this->discountedPrice;
	}

	public static function fromResponse($response, $couponCode, $event) {
		return new CouponCodeValidateResponse(
			$response['valid'],
			$response['reason'],
			$couponCode,
			$event,
			Price::fromResponse($response['discountedPrice'])
		);
	}
}
