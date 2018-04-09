<?php

use Ixolit\Dislo\Response\SubscriptionExternalCreateResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionExternalCreateResponseTest
 */
class SubscriptionExternalCreateResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();

        $subscriptionExternalCreateResponse = new SubscriptionExternalCreateResponse($subscription);

        $reflectionObject = new \ReflectionObject($subscriptionExternalCreateResponse);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionExternalCreateResponse), $subscription);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();

        $subscriptionExternalCreateResponse = new SubscriptionExternalCreateResponse($subscription);

        $this->compareSubscription($subscriptionExternalCreateResponse->getSubscription(), $subscription);
    }

    public function testFromResponse() {
        $subscription = SubscriptionMock::create();

        $response = [
            'subscription' => $subscription->toArray(),
        ];

        $subscriptionExternalCreateResponse = SubscriptionExternalCreateResponse::fromResponse($response);

        $this->compareSubscription($subscriptionExternalCreateResponse->getSubscription(), $subscription);
    }

}