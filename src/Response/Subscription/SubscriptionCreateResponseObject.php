<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\Subscription\PriceObject;
use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;


/**
 * Class SubscriptionCreateResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionCreateResponseObject implements SubscriptionResponseInterface {

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
     * @param SubscriptionObject $subscription
     * @param bool               $needsBilling
     * @param PriceObject        $price
     * @param bool               $requireFlexible
     */
    public function __construct(
        SubscriptionObject $subscription,
        $needsBilling,
        PriceObject $price,
        $requireFlexible = false
    ) {
        $this->subscription    = $subscription;
        $this->needsBilling    = $needsBilling;
        $this->price           = $price;
        $this->requireFlexible = $requireFlexible;
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
     * @param array $response
     *
     * @return SubscriptionCreateResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            SubscriptionObject::fromResponse($response['subscription']),
            $response['needsBilling'],
            PriceObject::fromResponse($response['price']),
            isset($response['requireFlexibleForFreeUpgrade'])
                ? $response['requireFlexibleForFreeUpgrade']
                : false
        );
    }

}