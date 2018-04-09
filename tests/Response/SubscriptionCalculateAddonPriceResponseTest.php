<?php

use Ixolit\Dislo\Response\SubscriptionCalculateAddonPriceResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;

/**
 * Class SubscriptionCalculateAddonPriceResponseTest
 */
class SubscriptionCalculateAddonPriceResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();

        $subscriptionCalculateAddonPriceResponse = new SubscriptionCalculateAddonPriceResponse($needsBilling, $price);

        $reflectionObject = new \ReflectionObject($subscriptionCalculateAddonPriceResponse);

        $needsBillingProperty = $reflectionObject->getProperty('needsBilling');
        $needsBillingProperty->setAccessible(true);
        $this->assertEquals($needsBilling, $needsBillingProperty->getValue($subscriptionCalculateAddonPriceResponse));

        $priceProperty = $reflectionObject->getProperty('price');
        $priceProperty->setAccessible(true);
        $this->comparePrice($priceProperty->getValue($subscriptionCalculateAddonPriceResponse), $price);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();

        $subscriptionCalculateAddonPriceResponse = new SubscriptionCalculateAddonPriceResponse($needsBilling, $price);

        $this->assertEquals($needsBilling, $subscriptionCalculateAddonPriceResponse->isNeedsBilling());
        $this->comparePrice($subscriptionCalculateAddonPriceResponse->getPrice(), $price);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $price = PriceMock::create();

        $response = [
            'needsBilling' => MockHelper::getFaker()->boolean(),
            'price'        => $price->toArray(),
        ];

        $subscriptionCalculateAddonPriceResponse = SubscriptionCalculateAddonPriceResponse::fromResponse($response);

        $this->assertEquals($response['needsBilling'], $subscriptionCalculateAddonPriceResponse->isNeedsBilling());
        $this->comparePrice($subscriptionCalculateAddonPriceResponse->getPrice(), $price);
    }

}