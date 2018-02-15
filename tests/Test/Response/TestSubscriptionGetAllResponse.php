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
     *
     * @param string|null $minimumOneState
     */
    public function __construct($minimumOneState = null) {
        $subscriptionsCount = MockHelper::getFaker()->numberBetween(1, 10);

        for ($i = 0; $i < $subscriptionsCount; $i++) {
            $subscription = SubscriptionMock::create($minimumOneState);

            $this->subscriptions[$subscription->getSubscriptionId()] = $subscription;

            $minimumOneState = null;
        }
    }

    /**
     * @return SubscriptionObject[]
     */
    public function getSubscriptions() {
        return $this->subscriptions;
    }

    /**
     * @return SubscriptionObject[]
     */
    public function getActiveSubscriptions() {
        return \array_filter(
            $this->getSubscriptions(),
            function(SubscriptionObject $subscription) {
                return \in_array(
                    $subscription->getStatus(),
                    [
                        SubscriptionObject::STATUS_CANCELED,
                        SubscriptionObject::STATUS_RUNNING,
                    ]
                );
            }
        );
    }

    /**
     * @return SubscriptionObject[]
     */
    public function getStartedSubscriptions() {
        return \array_filter(
            $this->getSubscriptions(),
            function (SubscriptionObject $subscription) {
                return !empty($subscription->getStartedAt());
            }
        );
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