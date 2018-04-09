<?php

use Ixolit\Dislo\Response\SubscriptionExternalChangePeriodResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionExternalChangePeriodResponseTest
 */
class SubscriptionExternalChangePeriodResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();

        $subscriptionExternalChangePeriodResponse = new SubscriptionExternalChangePeriodResponse($subscription);

        $reflectionObject = new \ReflectionObject($subscriptionExternalChangePeriodResponse);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionExternalChangePeriodResponse), $subscription);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();

        $subscriptionExternalChangePeriodResponse = new SubscriptionExternalChangePeriodResponse($subscription);

        $this->compareSubscription($subscriptionExternalChangePeriodResponse->getSubscription(), $subscription);
    }

    public function testFromResponse() {
        $subscription = SubscriptionMock::create();

        $response = [
            'subscription' => $subscription->toArray(),
        ];

        $subscriptionExternalChangePeriodResponse = SubscriptionExternalChangePeriodResponse::fromResponse($response);

        $this->compareSubscription($subscriptionExternalChangePeriodResponse->getSubscription(), $subscription);
    }

}