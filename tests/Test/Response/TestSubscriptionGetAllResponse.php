<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;

/**
 * Class TestSubscriptionGetAllResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionGetAllResponse implements TestResponseInterface {

    /**
     * @var SubscriptionObject[]
     */
    public $subscriptions;

    /**
     * TestSubscriptionGetAllResponse constructor.
     */
    public function __construct() {
        $subscriptionsCount = MockHelper::getFaker()->numberBetween(1, 5);

        for ($i = 0; $i < $subscriptionsCount; $i++) {
            $subscription = SubscriptionMock::create();

            $this->subscriptions[$subscription->getSubscriptionId()] = $subscription;
        }
    }

    /**
     * @return SubscriptionObject[]
     */
    public function getSubscriptions() {
        return $this->subscriptions;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        $subscriptions = [];
        foreach ($this->getSubscriptions() as $subscription) {
            $subscriptions[] = $subscription->toArray();
        }

        return [
            'subscriptions' => $subscriptions,
        ];
    }

}