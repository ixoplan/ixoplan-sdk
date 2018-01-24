<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\PriceObject;

/**
 * Class SubscriptionCalculatePackageChangeResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionCalculatePackageChangeResponseObject {

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
     * SubscriptionCalculatePackageChangeResponseObject constructor.
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
     * @return SubscriptionCalculatePackageChangeResponseObject
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