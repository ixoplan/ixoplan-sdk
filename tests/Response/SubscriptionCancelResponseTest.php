<?php

use Ixolit\Dislo\Response\SubscriptionCancelResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionCancelResponseTest
 */
class SubscriptionCancelResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();

        $subscriptionCancelResponse = new SubscriptionCancelResponse($subscription);

        $reflectionObject = new \ReflectionObject($subscriptionCancelResponse);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionCancelResponse), $subscription);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();

        $subscriptionCancelResponse = new SubscriptionCancelResponse($subscription);

        $this->compareSubscription($subscriptionCancelResponse->getSubscription(), $subscription);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $subscription = SubscriptionMock::create();

        $response = [
            'subscription' => $subscription->toArray(),
        ];

        $subscriptionCancelResponse = SubscriptionCancelResponse::fromResponse($response);

        $this->compareSubscription($subscriptionCancelResponse->getSubscription(), $subscription);
    }

}