<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;

/**
 * Class SubscriptionExternalCloseResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionExternalCloseResponseObject {

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
     * @return SubscriptionExternalCloseResponseObject
     */
    public static function fromResponse($response) {
        return new self(SubscriptionObject::fromResponse($response['subscription']));
    }

}