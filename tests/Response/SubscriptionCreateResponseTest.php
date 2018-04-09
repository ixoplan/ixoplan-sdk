<?php

use Ixolit\Dislo\Response\SubscriptionCreateResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionCreateResponseTest
 */
class SubscriptionCreateResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();
        $subscription = SubscriptionMock::create();
        $requireFlexible = MockHelper::getFaker()->boolean();

        $subscriptionCreateResponse = new SubscriptionCreateResponse(
            $needsBilling,
            $price,
            $subscription,
            $requireFlexible
        );

        $reflectionObject = new \ReflectionObject($subscriptionCreateResponse);
        $reflectionObject = $reflectionObject->getParentClass();

        $needsBillingProperty = $reflectionObject->getProperty('needsBilling');
        $needsBillingProperty->setAccessible(true);
        $this->assertEquals($needsBilling, $needsBillingProperty->getValue($subscriptionCreateResponse));

        $priceProperty = $reflectionObject->getProperty('price');
        $priceProperty->setAccessible(true);
        $this->comparePrice($priceProperty->getValue($subscriptionCreateResponse), $price);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionCreateResponse), $subscription);

        $requireFlexibleProperty = $reflectionObject->getProperty('requireFlexible');
        $requireFlexibleProperty->setAccessible(true);
        $this->assertEquals($requireFlexible, $requireFlexibleProperty->getValue($subscriptionCreateResponse));

        new SubscriptionCreateResponse(
            $needsBilling,
            $price,
            $subscription
        );
    }

    /**
     * @return void
     */
    public function testGetters() {
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();
        $subscription = SubscriptionMock::create();
        $requireFlexible = MockHelper::getFaker()->boolean();

        $subscriptionCreateResponse = new SubscriptionCreateResponse(
            $needsBilling,
            $price,
            $subscription,
            $requireFlexible
        );

        $this->assertEquals($needsBilling, $subscriptionCreateResponse->needsBilling());
        $this->comparePrice($subscriptionCreateResponse->getPrice(), $price);
        $this->compareSubscription($subscriptionCreateResponse->getSubscription(), $subscription);
        $this->assertEquals($requireFlexible, $subscriptionCreateResponse->requiresFlexible());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $price = PriceMock::create();
        $subscription = SubscriptionMock::create();

        $response = [
            'needsBilling'                 => MockHelper::getFaker()->boolean(),
            'requireFlexibleForFreeSignup' => MockHelper::getFaker()->boolean(),
            'price'                        => $price->toArray(),
            'subscription'                 => $subscription->toArray(),
        ];

        $subscriptionCreateResponse = SubscriptionCreateResponse::fromResponse($response);

        $this->assertEquals($response['needsBilling'], $subscriptionCreateResponse->needsBilling());
        $this->comparePrice($subscriptionCreateResponse->getPrice(), $price);
        $this->compareSubscription($subscriptionCreateResponse->getSubscription(), $subscription);
        $this->assertEquals($response['requireFlexibleForFreeSignup'], $subscriptionCreateResponse->requiresFlexible());
    }

}