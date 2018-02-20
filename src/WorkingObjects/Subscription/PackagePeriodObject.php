<?php

namespace Ixolit\Dislo\WorkingObjects\Subscription;


use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;


/**
 * Class PackagePeriodObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class PackagePeriodObject extends AbstractWorkingObject {

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
     * @var array|PriceObject[]
     */
    private $basePrice = [];

    /**
     * @var int|null
     */
    private $minimumTermLength;

    /**
     * @param int           $length
     * @param string        $lengthUnit
     * @param array         $metaData
     * @param PriceObject[] $basePrice
     * @param int|null      $minimumTermLength
     */
    public function __construct($length, $lengthUnit, $metaData = [], $basePrice = [], $minimumTermLength = null) {
        $this->length     		 = $length;
        $this->lengthUnit 		 = $lengthUnit;
        $this->metaData   		 = $metaData;
        $this->basePrice  		 = $basePrice;
        $this->minimumTermLength = $minimumTermLength;
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
     * @return PriceObject[]
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
     * @param string $currency
     *
     * @return PriceObject|mixed
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
     * @return PackagePeriodObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValue($response, 'length'),
            static::getValue($response, 'lengthUnit'),
            static::getValue($response, 'metaData', []),
            static::getValue($response, 'basePrice', [], function ($value) {
                $prices = [];
                foreach ($value as $price) {
                    $prices[] = PriceObject::fromResponse($price);
                }
                return $prices;
            }),
            static::getValue($response, 'minimumTermLength')
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