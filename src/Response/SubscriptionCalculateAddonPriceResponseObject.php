<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\PriceObject;

/**
 * Class SubscriptionCalculateAddonPriceResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionCalculateAddonPriceResponseObject {

    /**
     * @var bool
     */
    private $needsBilling;

    /**
     * @var PriceObject
     */
    private $price;

    /**
     * SubscriptionCalculateAddonPriceResponse constructor.
     *
     * @param bool        $needsBilling
     * @param PriceObject $price
     */
    public function __construct($needsBilling, PriceObject $price) {
        $this->needsBilling = $needsBilling;
        $this->price        = $price;
    }

    /**
     * @return boolean
     */
    public function isNeedsBilling() {
        return $this->needsBilling;
    }

    /**
     * @return PriceObject
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionCalculateAddonPriceResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            $response['needsBilling'],
            PriceObject::fromResponse($response['price'])
        );
    }

}