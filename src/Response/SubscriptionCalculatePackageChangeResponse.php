<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;

class SubscriptionCalculatePackageChangeResponse {
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
	 * SubscriptionCalculateAddonPriceResponse constructor.
	 *
	 * @param bool  $needsBilling
	 * @param Price $price
	 * @param bool  $appliedImmediately
	 */
	public function __construct($needsBilling, Price $price, $appliedImmediately) {
		$this->needsBilling = $needsBilling;
		$this->price        = $price;
		$this->appliedImmediately = $appliedImmediately;
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
	 * @return SubscriptionCalculatePackageChangeResponse
	 */
	public static function fromResponse($response) {
		return new SubscriptionCalculatePackageChangeResponse(
			$response['needsBilling'],
			Price::fromResponse($response['price']),
			$response['appliedImmediately']
		);
	}
}