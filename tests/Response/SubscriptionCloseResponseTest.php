<?php

use Ixolit\Dislo\Response\SubscriptionCloseResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionCloseResponseTest
 */
class SubscriptionCloseResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();

        $subscriptionCloseResponse = new SubscriptionCloseResponse($subscription);

        $reflectionObject = new \ReflectionObject($subscriptionCloseResponse);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionCloseResponse), $subscription);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();

        $subscriptionCloseResponse = new SubscriptionCloseResponse($subscription);

        $this->compareSubscription($subscriptionCloseResponse->getSubscription(), $subscription);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $subscription = SubscriptionMock::create();

        $response = [
            'subscription' => $subscription->toArray(),
        ];

        $subscriptionCloseResponse = SubscriptionCloseResponse::fromResponse($response);

        $this->compareSubscription($subscriptionCloseResponse->getSubscription(), $subscription);
    }

}