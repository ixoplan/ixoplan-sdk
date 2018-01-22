<?php

namespace Ixolit\Dislo\WorkingObjects;


use Ixolit\Dislo\Exceptions\ObjectNotFoundException;


/**
 * Class PlanPeriod
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class PlanPeriod implements WorkingObject {


    /** @var int */
    private $length;

    /** @var string */
    private $lengthUnit;

    /** @var array */
    private $metaData = [];

    /** @var array|Price[] */
    private $basePrice = [];

    /** @var int|null */
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

        return new self(
            $response['length'],
            $response['lengthUnit'],
            isset($response['metaData'])
                ? $response['metaData']
                : [],
            $prices,
            isset($response['minimumTermLength'])
                ? $response['minimumTermLength']
                : null
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
            'length'            => $this->getLength(),
            'lengthUnit'        => $this->getLengthUnit(),
            'metaData'          => $this->getMetaData(),
            'basePrice'         => $basePrice,
            'minimumTermLength' => $this->getMinimumTermLength(),
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

    /**
     * @return int|null
     */
    public function getMinimumTermLength() {
        return $this->minimumTermLength;
    }

    public function getBasePriceForCurrency($currency) {
        foreach ($this->getBasePrice() as $price) {
            if ($price->getCurrencyCode() == $currency) {
                return $price;
            }
        }

        throw new ObjectNotFoundException('No base price for currency: ' . $currency);
    }

    public function isPaid() {
        foreach ($this->basePrice as $price) {
            if ($price->getAmount() > 0) {
                return true;
            }
        }
        return false;
    }

}