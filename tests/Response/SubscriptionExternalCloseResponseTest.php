<?php

use Ixolit\Dislo\Response\SubscriptionExternalCloseResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionExternalCloseResponseTest
 */
class SubscriptionExternalCloseResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();

        $subscriptionExternalCloseResponse = new SubscriptionExternalCloseResponse($subscription);

        $reflectionObject = new \ReflectionObject($subscriptionExternalCloseResponse);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionExternalCloseResponse), $subscription);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();

        $subscriptionExternalCloseResponse = new SubscriptionExternalCloseResponse($subscription);

        $this->compareSubscription($subscriptionExternalCloseResponse->getSubscription(), $subscription);
    }

    public function testFromResponse() {
        $subscription = SubscriptionMock::create();

        $response = [
            'subscription' => $subscription->toArray(),
        ];

        $subscriptionExternalCloseResponse = SubscriptionExternalCloseResponse::fromResponse($response);

        $this->compareSubscription($subscriptionExternalCloseResponse->getSubscription(), $subscription);
    }

}