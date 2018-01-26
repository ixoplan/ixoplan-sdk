<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\SubscriptionObject;

/**
 * Class SubscriptionCancelResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionCancelResponseObject {

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
     * @param array $response
     *
     * @return SubscriptionCancelResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            SubscriptionObject::fromResponse($response['subscription'])
        );
    }

}