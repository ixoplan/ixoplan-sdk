<?php

use Ixolit\Dislo\Response\SubscriptionGetAllResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class SubscriptionGetAllResponseTest
 */
class SubscriptionGetAllResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();
        $subscriptions = [
            $subscription->getSubscriptionId() => $subscription,
        ];

        $subscriptionGetAllResponse = new SubscriptionGetAllResponse($subscriptions);

        $reflectionObject = new \ReflectionObject($subscriptionGetAllResponse);

        $subscriptionsProperty = $reflectionObject->getProperty('subscriptions');
        $subscriptionsProperty->setAccessible(true);

        /** @var Subscription[] $testSubscriptions */
        $testSubscriptions = $subscriptionsProperty->getValue($subscriptionGetAllResponse);
        foreach ($testSubscriptions as $testSubscription) {
            if (empty($subscriptions[$testSubscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($testSubscription, $subscriptions[$testSubscription->getSubscriptionId()]);
        }
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();
        $subscriptions = [
            $subscription->getSubscriptionId() => $subscription,
        ];

        $subscriptionGetAllResponse = new SubscriptionGetAllResponse($subscriptions);

        $testSubscriptions = $subscriptionGetAllResponse->getSubscriptions();
        foreach ($testSubscriptions as $testSubscription) {
            if (empty($subscriptions[$testSubscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($testSubscription, $subscriptions[$testSubscription->getSubscriptionId()]);
        }
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $subscription = SubscriptionMock::create();
        $subscriptions = [
            $subscription->getSubscriptionId() => $subscription,
        ];

        $response = [
            'subscriptions' => \array_map(
                function($subscription) {
                    /** @var Subscription $subscription */
                    return $subscription->toArray();
                },
                $subscriptions
            )
        ];

        $subscriptionGetAllResponse = SubscriptionGetAllResponse::fromResponse($response);

        $testSubscriptions = $subscriptionGetAllResponse->getSubscriptions();
        foreach ($testSubscriptions as $testSubscription) {
            if (empty($subscriptions[$testSubscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($testSubscription, $subscriptions[$testSubscription->getSubscriptionId()]);
        }
    }

}