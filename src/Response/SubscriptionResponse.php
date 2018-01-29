<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Subscription;


/**
 * Class SubscriptionResponse
 *
 * @package Ixolit\Dislo\Response
 */
abstract class SubscriptionResponse {

    /** @var Subscription */
    private $subscription;

    /** @var bool */
    private $needsBilling;

    /** @var Price */
    private $price;

    /** @var bool */
    private $requireFlexible;

    /**
     * SubscriptionResponse constructor.
     *
     * @param Subscription $subscription
     * @param bool         $needsBilling
     * @param Price        $price
     * @param bool         $requireFlexible
     */
    public function __construct(Subscription $subscription, $needsBilling, Price $price, $requireFlexible = false) {
        $this->subscription    = $subscription;
        $this->needsBilling    = $needsBilling;
        $this->price           = $price;
        $this->requireFlexible = $requireFlexible;
    }

    /**
     * @return Subscription
     */
    public function getSubscription() {
        return $this->subscription;
    }

    /**
     * @return bool
     */
    public function needsBilling() {
        return $this->needsBilling;
    }

    /**
     * @return Price
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @return bool
     */
    public function requiresFlexible() {
        return $this->requireFlexible;
    }

}