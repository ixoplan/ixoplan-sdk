<?php

use Ixolit\Dislo\Response\SubscriptionContinueResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionContinueResponseTest
 */
class SubscriptionContinueResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();

        $subscriptionContinueResponse = new SubscriptionContinueResponse($subscription);

        $reflectionObject = new \ReflectionObject($subscriptionContinueResponse);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionContinueResponse), $subscription);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();

        $subscriptionContinueResponse = new SubscriptionContinueResponse($subscription);

        $this->compareSubscription($subscriptionContinueResponse->getSubscription(), $subscription);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $subscription = SubscriptionMock::create();

        $response = [
            'subscription' => $subscription->toArray(),
        ];

        $subscriptionContinueResponse = SubscriptionContinueResponse::fromResponse($response);

        $this->compareSubscription($subscriptionContinueResponse->getSubscription(), $subscription);
    }

}