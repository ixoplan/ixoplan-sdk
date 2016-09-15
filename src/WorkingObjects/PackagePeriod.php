<?php

namespace Ixolit\Dislo\WorkingObjects;

class PackagePeriod implements WorkingObject {
	private $length;
	private $lengthUnit;
	private $metaData = [];
	private $basePrice = [];

	/**
	 * @param int     $length
	 * @param string  $lengthUnit
	 * @param array   $metaData
	 * @param Price[] $basePrice
	 */
	public function __construct(
		$length,
		$lengthUnit,
		$metaData = [],
		$basePrice = []
	) {
		$this->length     = $length;
		$this->lengthUnit = $lengthUnit;
		$this->metaData   = $metaData;
		$this->basePrice  = $basePrice;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		$prices = [];
		foreach ($response['basePrice'] as $price) {
			$prices[] = Price::fromResponse($price);
		}

		return new PackagePeriod(
			$response['length'],
			$response['lengthUnit'],
			$response['metaData'],
			$prices
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$basePrice = [];
		foreach ($this->basePrice as $price) {
			$basePrice[] = $price->toArray();
		}

		return [
			'_type'      => 'PackagePeriod',
			'length'     => $this->length,
			'lengthUnit' => $this->lengthUnit,
			'metaData'   => $this->metaData,
			'basePrice'  => $basePrice,
		];
	}

	/**
	 * @return int
	 */
	public function getLength() {
		return $this->length;
	}

	/**
	 * @return string
	 */
	public function getLengthUnit() {
		return $this->lengthUnit;
	}

	/**
	 * @return array
	 */
	public function getMetaData() {
		return $this->metaData;
	}

	/**
	 * @return Price[]
	 */
	public function getBasePrice() {
		return $this->basePrice;
	}
}