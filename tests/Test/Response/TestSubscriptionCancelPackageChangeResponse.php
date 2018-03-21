<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class TestSubscriptionCancelPackageChangeResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionCancelPackageChangeResponse implements TestResponseInterface {

    /**
     * @var Subscription[]
     */
    private $subscriptions;

    /**
     * TestSubscriptionCancelPackageChangeResponse constructor.
     */
    public function __construct() {
        $subscriptionCount = MockHelper::getFaker()->numberBetween(1, 5);

        $subscriptions = [];
        for ($i = 0; $i < $subscriptionCount; $i++) {
            $subscription = SubscriptionMock::create();

            $subscriptions[$subscription->getSubscriptionId()] = $subscription;
        }

        $this->subscriptions = $subscriptions;
    }

    /**
     * @return array|Subscription[]
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