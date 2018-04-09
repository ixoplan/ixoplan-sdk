<?php

use Ixolit\Dislo\Response\SubscriptionGetResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionGetResponseTest
 */
class SubscriptionGetResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstruct() {
        $subscription = SubscriptionMock::create();

        $subscriptionGetResponse = new SubscriptionGetResponse($subscription);

        $reflectionObject = new \ReflectionObject($subscriptionGetResponse);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionGetResponse), $subscription);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();

        $subscriptionGetResponse = new SubscriptionGetResponse($subscription);

        $this->compareSubscription($subscriptionGetResponse->getSubscription(), $subscription);
    }

    public function testFromResponse() {
        $subscription = SubscriptionMock::create();

        $response = [
            'subscription' => $subscription->toArray(),
        ];

        $subscriptionGetResponse = SubscriptionGetResponse::fromResponse($response);

        $this->compareSubscription($subscriptionGetResponse->getSubscription(), $subscription);
    }

}