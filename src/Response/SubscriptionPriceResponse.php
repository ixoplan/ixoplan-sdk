<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\Price;

/**
 * Class SubscriptionPriceResponse
 *
 * @package Ixolit\Dislo\Response
 */
abstract class SubscriptionPriceResponse {

    /**
     * @var Price
     */
    private $price;

    /** @var Price|null */
    private $recurringPrice;

    /**
     * SubscriptionPriceResponse constructor.
     *
     * @param Price      $price
     * @param Price|null $recurringPrice
     */
    public function __construct(Price $price, Price $recurringPrice = null) {
        $this->price = $price;
        $this->recurringPrice = $recurringPrice;
    }

    /**
     * @return Price
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @return Price|null
     */
    public function getRecurringPrice() {
        return $this->recurringPrice;
    }

}