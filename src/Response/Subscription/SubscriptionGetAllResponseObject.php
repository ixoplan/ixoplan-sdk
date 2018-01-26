<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;


/**
 * Class SubscriptionGetAllResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionGetAllResponseObject {

    /**
     * @var SubscriptionObject[]
     */
    private $subscriptions;

    /**
     * @param SubscriptionObject[] $subscriptions
     */
    public function __construct(array $subscriptions) {
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
     * @return SubscriptionGetAllResponseObject
     */
    public static function fromResponse($response) {
        $subscriptions = [];

        foreach ($response['subscriptions'] as $subscriptionDefinition) {
            $subscriptions[] = SubscriptionObject::fromResponse($subscriptionDefinition);
        }

        return new self($subscriptions);
    }

}