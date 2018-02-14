<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\Subscription\PriceObject;

/**
 * Class SubscriptionCalculatePriceResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionCalculatePriceResponseObject {

    /**
     * @var PriceObject
     */
    private $price;

    /**
     * @var bool
     */
    private $needsBilling;

    /**
     * @var bool
     */
    private $appliedImmediately;

    /**
     * @var PriceObject|null
     */
    private $recurringPrice;

    /**
     * SubscriptionCalculatePriceResponseObject constructor.
     *
     * @param PriceObject      $price
     * @param bool             $needsBilling
     * @param bool             $appliedImmediately
     * @param PriceObject|null $recurringPrice
     */
    public function __construct(
        PriceObject $price,
        $needsBilling,
        $appliedImmediately,
        PriceObject $recurringPrice = null
    ) {
        $this->price = $price;
        $this->recurringPrice = $recurringPrice;
        $this->needsBilling = $needsBilling;
        $this->appliedImmediately = $appliedImmediately;
    }

    /**
     * @return PriceObject
     */
    public function getPrice() {
        return $this->price;
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
     * @return PriceObject|null
     */
    public function getRecurringPrice() {
        return $this->recurringPrice;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionCalculatePriceResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            PriceObject::fromResponse($response['price']),
            $response['needsBilling'],
            $response['appliedImmediately'],
            isset($response['recurringPrice'])
                ? PriceObject::fromResponse($response['recurringPrice'])
                : null
        );
    }

}