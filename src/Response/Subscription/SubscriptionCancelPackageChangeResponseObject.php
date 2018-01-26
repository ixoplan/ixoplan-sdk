<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;


/**
 * Class SubscriptionCancelPackageChangeResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionCancelPackageChangeResponseObject {

    /**
     * @var SubscriptionObject[]
     */
    private $subscriptions;

    /**
     * @param SubscriptionObject[] $subscriptions
     */
    public function __construct($subscriptions) {
        $this->subscriptions = $subscriptions;
    }

    /**
     * @return SubscriptionObject[]
     */
    public function getSubscriptions() {
        return $this->subscriptions;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionCancelPackageChangeResponseObject
     */
    public static function fromResponse($response) {
        $subscriptions = [];
        foreach ($response['subscriptions'] as $subscriptionData) {
            $subscriptions[] = SubscriptionObject::fromResponse($subscriptionData);
        }
        return new self($subscriptions);
    }

}