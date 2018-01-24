<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\SubscriptionObject;

/**
 * Class SubscriptionGetResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionGetResponseObject {

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
     * @return SubscriptionGetResponseObject
     */
    public static function fromResponse($response) {
        return new self(SubscriptionObject::fromResponse($response['subscription']));
    }

}