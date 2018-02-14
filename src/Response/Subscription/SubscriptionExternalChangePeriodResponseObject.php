<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;

/**
 * Class SubscriptionExternalChangePeriodResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionExternalChangePeriodResponseObject {

    /**
     * @var SubscriptionObject
     */
    private $subscription;

    /**
     * @param SubscriptionObject $subscription
     */
    public function __construct(SubscriptionObject $subscription) {
        $this->subscription = $subscription;
    }

    /**
     * @return SubscriptionObject
     */
    public function getSubscription() {
        return $this->subscription;
    }

    /**
     * @param $response
     *
     * @return SubscriptionExternalChangePeriodResponseObject
     */
    public static function fromResponse($response) {
        return new self(SubscriptionObject::fromResponse(\reset($response)));
    }

}