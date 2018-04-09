<?php

use Ixolit\Dislo\Response\SubscriptionCreateAddonResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionCreateAddonResponseTest
 */
class SubscriptionCreateAddonResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();

        $subscriptionCreateAddonResponse = new SubscriptionCreateAddonResponse($subscription, $needsBilling, $price);

        $reflectionObject = new \ReflectionObject($subscriptionCreateAddonResponse);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionCreateAddonResponse), $subscription);

        $needsBillingProperty = $reflectionObject->getProperty('needsBilling');
        $needsBillingProperty->setAccessible(true);
        $this->assertEquals($needsBilling, $needsBillingProperty->getValue($subscriptionCreateAddonResponse));

        $priceProperty = $reflectionObject->getProperty('price');
        $priceProperty->setAccessible(true);
        $this->comparePrice($priceProperty->getValue($subscriptionCreateAddonResponse), $price);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();

        $subscriptionCreateAddonResponse = new SubscriptionCreateAddonResponse($subscription, $needsBilling, $price);

        $this->compareSubscription($subscriptionCreateAddonResponse->getSubscription(), $subscription);
        $this->assertEquals($needsBilling, $subscriptionCreateAddonResponse->isNeedsBilling());
        $this->comparePrice($subscriptionCreateAddonResponse->getPrice(), $price);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $subscription = SubscriptionMock::create();
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();

        $response = [
            'subscription' => $subscription->toArray(),
            'needsBilling' => MockHelper::getFaker()->boolean(),
            'price'        => $price->toArray(),
        ];

        $subscriptionCreateAddonResponse = SubscriptionCreateAddonResponse::fromResponse($response);

        $this->compareSubscription($subscriptionCreateAddonResponse->getSubscription(), $subscription);
        $this->assertEquals($response['needsBilling'], $subscriptionCreateAddonResponse->isNeedsBilling());
        $this->comparePrice($subscriptionCreateAddonResponse->getPrice(), $price);
    }

}