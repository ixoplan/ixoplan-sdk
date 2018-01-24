<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\PriceObject;
use Ixolit\Dislo\WorkingObjects\SubscriptionObject;


/**
 * Class SubscriptionCreateAddonResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionCreateAddonResponseObject {

    /**
     * @var SubscriptionObject
     */
    private $subscription;

    /**
     * @var bool
     */
    private $needsBilling;

    /**
     * @var PriceObject
     */
    private $price;

    /**
     * @param SubscriptionObject $subscription
     * @param bool               $needsBilling
     * @param PriceObject        $price
     */
    public function __construct(SubscriptionObject $subscription, $needsBilling, PriceObject $price) {
        $this->subscription = $subscription;
        $this->needsBilling = $needsBilling;
        $this->price        = $price;
    }

    /**
     * @return SubscriptionObject
     */
    public function getSubscription() {
        return $this->subscription;
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
     * @return SubscriptionCreateAddonResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            SubscriptionObject::fromResponse($response['subscription']),
            $response['needsBilling'],
            PriceObject::fromResponse($response['price'])
        );
    }

}