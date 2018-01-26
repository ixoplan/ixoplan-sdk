<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\PriceObject;
use Ixolit\Dislo\WorkingObjects\SubscriptionObject;

/**
 * Class SubscriptionChangeResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionChangeResponseObject implements SubscriptionResponseInterface {

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
     * @var bool
     */
    private $requireFlexible;

    /**
     * @var bool
     */
    private $appliedImmediately;

    /**
     * @param SubscriptionObject $subscription
     * @param bool               $needsBilling
     * @param PriceObject        $price
     * @param bool               $appliedImmediately
     * @param bool               $requireFlexible
     */
    public function __construct(
        SubscriptionObject $subscription,
        $needsBilling,
        PriceObject $price,
        $appliedImmediately,
        $requireFlexible = false
    ) {
        $this->subscription    = $subscription;
        $this->needsBilling    = $needsBilling;
        $this->price           = $price;
        $this->requireFlexible = $requireFlexible;
        $this->appliedImmediately = $appliedImmediately;
    }

    /**
     * @return SubscriptionObject
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
     * @return PriceObject
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

    /**
     * @return boolean
     */
    public function isAppliedImmediately() {
        return $this->appliedImmediately;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionChangeResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            SubscriptionObject::fromResponse($response['subscription']),
            $response['needsBilling'],
            PriceObject::fromResponse($response['price']),
            $response['appliedImmediately'],
            isset($response['requireFlexibleForFreeUpgrade'])
                ? $response['requireFlexibleForFreeUpgrade']
                : false
        );
    }

}