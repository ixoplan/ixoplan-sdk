<?php

namespace Ixolit\Dislo\WorkingObjects;


/**
 * Class Price
 *
 * @package Ixolit\Dislo\WorkingObjects
 *
 * @deprecated use Ixolit\Dislo\WorkingObjects PriceObject instead
 */
class Price implements WorkingObject {
	const TAG_BASEPRICE = 'baseprice';
	const TAG_PRORATE_PRICE = 'prorate_price';
	const TAG_COUPON = 'coupon';
	const TAG_ACCOUNT_BALANCE = 'account_balance';
	const TAG_TOTALPRICE = 'totalprice';
	const TAG_SUBTOTAL = 'subtotal';

	/**
	 * Amount for the price
	 *
	 * @var float
	 */
	private $amount;
	/**
	 * Currency code for the price
	 *
	 * @var string
	 */
	private $currencyCode;
	/**
	 * Identifies the group to which this price belongs (e.g. package identifier)
	 *
	 * @var string
	 */
	private $group;
	/**
	 * Defines the type of price, options are
	 *
	 * @var string
	 */
	private $tag;
	/**
	 * @var Price[]
	 */
	private $compositePrices = [];

	/**
	 * Price constructor.
	 *
	 * @param float   $amount       amount for the price
	 * @param string  $currencyCode currency code for the price
	 * @param string  $group        identifies the group to which this price belongs (e.g. package identifier)
	 * @param string  $tag          defines the type of price, options are
	 * @param Price[] $compositePrices
	 */
	public function __construct($amount, $currencyCode, $tag, $group = '', $compositePrices = []) {
		$this->amount          = $amount;
		$this->currencyCode    = $currencyCode;
		$this->group           = $group;
		$this->tag             = $tag;
		$this->compositePrices = $compositePrices;
	}

	/**
	 * @return float
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * @return string
	 */
	public function getCurrencyCode() {
		return $this->currencyCode;
	}

	/**
	 * @return string
	 */
	public function getGroup() {
		return $this->group;
	}

	/**
	 * @return string
	 */
	public function getTag() {
		return $this->tag;
	}

	/**
	 * @return Price[]
	 */
	public function getCompositePrices() {
		return $this->compositePrices;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		$compositePrices = [];
		if (isset($response['compositePrices'])) {
			foreach ($response['compositePrices'] as $compositePrice) {
				$compositePrices[] = Price::fromResponse($compositePrice);
			}
		}

		return new Price(
			$response['amount'],
			$response['currencyCode'],
			$response['tag'],
			(isset($response['group'])?$response['group']:''),
			$compositePrices
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$result = [
			'_type' => 'Price',
		];
		$result['amount'] = $this->amount;
		$result['currencyCode'] = $this->currencyCode;
		if ($this->group) {
			$result['group'] = $this->group;
		}
		$result['tag'] = $this->tag;

		if ($this->compositePrices) {
			$result['compositePrices'] = [];
			foreach ($this->compositePrices as $compositePrice) {
				$result['compositePrices'][] = $compositePrice->toArray();
			}
		}
		return $result;
	}
}