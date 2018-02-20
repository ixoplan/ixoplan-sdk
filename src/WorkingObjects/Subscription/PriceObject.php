<?php

namespace Ixolit\Dislo\WorkingObjects\Subscription;


use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;


/**
 * Class PriceObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class PriceObject extends AbstractWorkingObject {

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
     * @var PriceObject[]
     */
    private $compositePrices = [];

    /**
     * Price constructor.
     *
     * @param float         $amount       amount for the price
     * @param string        $currencyCode currency code for the price
     * @param string        $group        identifies the group to which this price belongs (e.g. package identifier)
     * @param string        $tag          defines the type of price, options are
     * @param PriceObject[] $compositePrices
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
     * @return PriceObject[]
     */
    public function getCompositePrices() {
        return $this->compositePrices;
    }

    /**
     * @param array $response
     *
     * @return PriceObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValueIsSet($response, 'amount'),
            static::getValueIsSet($response, 'currencyCode'),
            static::getValueIsSet($response, 'tag'),
            static::getValueIsSet($response, 'group', ''),
            static::getValueIsSet($response, 'compositePrices', [], function ($value) {
                $compositePrices = [];
                foreach ($value as $compositePrice) {
                    $compositePrices[] = PriceObject::fromResponse($compositePrice);
                }
                return $compositePrices;
            })
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        $compositePrices = [];
        foreach ($this->compositePrices as $compositePrice) {
            $compositePrices[] = $compositePrice->toArray();
        }

        return [
            '_type'           => 'Price',
            'amount'          => $this->amount,
            'currencyCode'    => $this->currencyCode,
            'group'           => $this->group,
            'tag'             => $this->tag,
            'compositePrices' => $compositePrices,
        ];
    }

}