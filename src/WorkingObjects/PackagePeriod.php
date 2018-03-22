<?php

namespace Ixolit\Dislo\WorkingObjects;

use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\WorkingObjectsCustom\PackagePeriodCustom;

/**
 * Class PackagePeriod
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class PackagePeriod extends AbstractWorkingObject {

    /**
     * @var int
     */
	private $length;

    /**
     * @var string
     */
	private $lengthUnit;

    /**
     * @var array
     */
	private $metaData = [];

    /**
     * @var array|Price[]
     */
	private $basePrice = [];

    /**
     * @var int|null
     */
	private $minimumTermLength;

	/**
	 * @param int      $length
	 * @param string   $lengthUnit
	 * @param array    $metaData
	 * @param Price[]  $basePrice
	 * @param int|null $minimumTermLength
	 */
	public function __construct(
		$length,
		$lengthUnit,
		$metaData = [],
		$basePrice = [],
		$minimumTermLength = null
	) {
		$this->length     		 = $length;
		$this->lengthUnit 		 = $lengthUnit;
		$this->metaData   		 = $metaData;
		$this->basePrice  		 = $basePrice;
		$this->minimumTermLength = $minimumTermLength;

		$this->addCustomObject();
	}

    /**
     * @return PackagePeriodCustom|null
     */
    public function getCustom() {
        /** @var PackagePeriodCustom $custom */
        $custom = ($this->getCustomObject() instanceof PackagePeriodCustom) ? $this->getCustomObject() : null;
        return $custom;
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

    /**
	 * @return int|null
	 */
	public function getMinimumTermLength() {
		return $this->minimumTermLength;
	}

    /**
     * @param $currency
     *
     * @return Price
     *
     * @throws ObjectNotFoundException
     */
    public function getBasePriceForCurrency($currency) {
		foreach ($this->basePrice as $price) {
			if ($price->getCurrencyCode() == $currency) {
				return $price;
			}
		}
		throw new ObjectNotFoundException('No base price for currency: ' . $currency);
	}

    /**
     * @return bool
     */
    public function isPaid() {
		foreach ($this->basePrice as $price) {
			if ($price->getAmount() > 0) {
				return true;
			}
		}
		return false;
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
            isset($response['metaData']) ? $response['metaData'] : array(),
            $prices,
            isset($response['minimumTermLength']) ? $response['minimumTermLength'] : null
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
            '_type'             => 'PackagePeriod',
            'length'            => $this->length,
            'lengthUnit'        => $this->lengthUnit,
            'metaData'          => $this->metaData,
            'basePrice'         => $basePrice,
            'minimumTermLength' => $this->minimumTermLength,
        ];
    }

}