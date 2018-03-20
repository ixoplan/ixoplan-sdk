<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;

/**
 * Class SubscriptionCalculatePackageChangeResponse
 *
 * @package Ixolit\Dislo\Response
 */
class SubscriptionCalculatePackageChangeResponse extends SubscriptionPriceResponse {

	/**
	 * @var bool
	 */
	private $needsBilling;

	/**
	 * @var bool
	 */
	private $appliedImmediately;

    /**
     * SubscriptionCalculateAddonPriceResponse constructor.
     *
     * @param bool       $needsBilling
     * @param Price      $price
     * @param bool       $appliedImmediately
     * @param Price|null $recurringPrice
     */
	public function __construct($needsBilling, Price $price, $appliedImmediately, Price $recurringPrice = null) {
		$this->needsBilling = $needsBilling;
		$this->appliedImmediately = $appliedImmediately;

		parent::__construct($price, $recurringPrice);
	}

	/**
	 * @return boolean
	 */
	public function isNeedsBilling() {
		return $this->needsBilling;
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
			$response['appliedImmediately'],
            isset($response['recurringPrice'])
                ? Price::fromResponse($response['recurringPrice'])
                : null
		);
	}
}