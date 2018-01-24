<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\SubscriptionObject;

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
        return new self(SubscriptionObject::fromResponse($response['subscription']));
    }

}