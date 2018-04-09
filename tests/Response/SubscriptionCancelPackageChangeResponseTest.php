<?php

use Ixolit\Dislo\Response\SubscriptionCancelPackageChangeResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class SubscriptionCancelPackageChangeResponseTest
 */
class SubscriptionCancelPackageChangeResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();
        $subscriptions = [
            $subscription->getSubscriptionId() => $subscription,
        ];

        $subscriptionCancelPackageChangeResponse = new SubscriptionCancelPackageChangeResponse($subscriptions);

        $reflectionObject = new \ReflectionObject($subscriptionCancelPackageChangeResponse);

        $subscriptionsProperty = $reflectionObject->getProperty('subscriptions');
        $subscriptionsProperty->setAccessible(true);

        /** @var Subscription[] $testSubscriptions */
        $testSubscriptions = $subscriptionsProperty->getValue($subscriptionCancelPackageChangeResponse);
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

        $subscriptionCancelPackageChangeResponse = new SubscriptionCancelPackageChangeResponse($subscriptions);

        $testSubscriptions = $subscriptionCancelPackageChangeResponse->getSubscriptions();
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

        $subscriptionCancelPackageChangeResponse = SubscriptionCancelPackageChangeResponse::fromResponse($response);

        $testSubscriptions = $subscriptionCancelPackageChangeResponse->getSubscriptions();
        foreach ($testSubscriptions as $testSubscription) {
            if (empty($subscriptions[$testSubscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($testSubscription, $subscriptions[$testSubscription->getSubscriptionId()]);
        }
    }

}