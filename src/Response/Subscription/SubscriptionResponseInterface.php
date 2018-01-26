<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\PriceObject;
use Ixolit\Dislo\WorkingObjects\SubscriptionObject;

/**
 * Interface SubscriptionResponseInterface
 *
 * @package Ixolit\Dislo\Response
 */
interface SubscriptionResponseInterface {

    /**
     * @return SubscriptionObject
     */
    public function getSubscription();

    /**
     * @return bool
     */
    public function needsBilling();

    /**
     * @return PriceObject
     */
    public function getPrice();

    /**
     * @return bool
     */
    public function requiresFlexible();

}