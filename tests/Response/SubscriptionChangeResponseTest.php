<?php

use Ixolit\Dislo\Response\SubscriptionChangeResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionChangeResponseTest
 */
class SubscriptionChangeResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();
        $appliedImmediately = MockHelper::getFaker()->boolean();
        $requireFlexible = MockHelper::getFaker()->boolean();

        $subscriptionChangeResponse = new SubscriptionChangeResponse(
            $subscription,
            $needsBilling,
            $price,
            $appliedImmediately,
            $requireFlexible
        );

        $reflectionObject = new \ReflectionObject($subscriptionChangeResponse);

        $appliedImmediatelyProperty = $reflectionObject->getProperty('appliedImmediately');
        $appliedImmediatelyProperty->setAccessible(true);
        $this->assertEquals($appliedImmediately, $appliedImmediatelyProperty->getValue($subscriptionChangeResponse));

        $reflectionObject = $reflectionObject->getParentClass();

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionChangeResponse), $subscription);

        $needsBillingProperty = $reflectionObject->getProperty('needsBilling');
        $needsBillingProperty->setAccessible(true);
        $this->assertEquals($needsBilling, $needsBillingProperty->getValue($subscriptionChangeResponse));

        $priceProperty = $reflectionObject->getProperty('price');
        $priceProperty->setAccessible(true);
        $this->comparePrice($priceProperty->getValue($subscriptionChangeResponse), $price);

        $requireFlexibleProperty = $reflectionObject->getProperty('requireFlexible');
        $requireFlexibleProperty->setAccessible(true);
        $this->assertEquals($requireFlexible, $requireFlexibleProperty->getValue($subscriptionChangeResponse));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();
        $appliedImmediately = MockHelper::getFaker()->boolean();
        $requireFlexible = MockHelper::getFaker()->boolean();

        $subscriptionChangeResponse = new SubscriptionChangeResponse(
            $subscription,
            $needsBilling,
            $price,
            $appliedImmediately,
            $requireFlexible
        );

        $this->assertEquals($appliedImmediately, $subscriptionChangeResponse->isAppliedImmediately());
        $this->compareSubscription($subscriptionChangeResponse->getSubscription(), $subscription);
        $this->assertEquals($needsBilling, $subscriptionChangeResponse->needsBilling());
        $this->comparePrice($subscriptionChangeResponse->getPrice(), $price);
        $this->assertEquals($requireFlexible, $subscriptionChangeResponse->requiresFlexible());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $subscription = SubscriptionMock::create();
        $price = PriceMock::create();

        $response = [
            'subscription'       => $subscription->toArray(),
            'needsBilling'       => MockHelper::getFaker()->boolean(),
            'price'              => $price->toArray(),
            'appliedImmediately' => MockHelper::getFaker()->boolean(),
            'requireFlexibleForFreeUpgrade'   => MockHelper::getFaker()->boolean(),
        ];

        $subscriptionChangeResponse = SubscriptionChangeResponse::fromResponse($response);

        $this->assertEquals($response['appliedImmediately'], $subscriptionChangeResponse->isAppliedImmediately());
        $this->compareSubscription($subscriptionChangeResponse->getSubscription(), $subscription);
        $this->assertEquals($response['needsBilling'], $subscriptionChangeResponse->needsBilling());
        $this->comparePrice($subscriptionChangeResponse->getPrice(), $price);
        $this->assertEquals($response['requireFlexibleForFreeUpgrade'], $subscriptionChangeResponse->requiresFlexible());
    }

}