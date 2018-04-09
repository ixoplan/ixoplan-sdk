<?php

use Ixolit\Dislo\Response\SubscriptionCalculatePackageChangeResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;

/**
 * Class SubscriptionCalculatePackageChangeResponseTest
 */
class SubscriptionCalculatePackageChangeResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();
        $appliedImmediately = MockHelper::getFaker()->boolean();
        $recurringPrice = PriceMock::create();

        $subscriptionCalculatePackageChangeResponse = new SubscriptionCalculatePackageChangeResponse(
            $needsBilling,
            $price,
            $appliedImmediately,
            $recurringPrice
        );

        $reflectionObject = new \ReflectionObject($subscriptionCalculatePackageChangeResponse);

        $needsBillingProperty = $reflectionObject->getProperty('needsBilling');
        $needsBillingProperty->setAccessible(true);
        $this->assertEquals($needsBilling, $needsBillingProperty->getValue($subscriptionCalculatePackageChangeResponse));

        $appliedImmediatelyProperty = $reflectionObject->getProperty('appliedImmediately');
        $appliedImmediatelyProperty->setAccessible(true);
        $this->assertEquals($appliedImmediately, $appliedImmediatelyProperty->getValue($subscriptionCalculatePackageChangeResponse));

        $reflectionObject = $reflectionObject->getParentClass();

        $priceProperty = $reflectionObject->getProperty('price');
        $priceProperty->setAccessible(true);
        $this->comparePrice($priceProperty->getValue($subscriptionCalculatePackageChangeResponse), $price);

        $recurringPriceProperty = $reflectionObject->getProperty('recurringPrice');
        $recurringPriceProperty->setAccessible(true);
        $this->comparePrice($recurringPriceProperty->getValue($subscriptionCalculatePackageChangeResponse), $recurringPrice);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $needsBilling = MockHelper::getFaker()->boolean();
        $price = PriceMock::create();
        $appliedImmediately = MockHelper::getFaker()->boolean();
        $recurringPrice = PriceMock::create();

        $subscriptionCalculatePackageChangeResponse = new SubscriptionCalculatePackageChangeResponse(
            $needsBilling,
            $price,
            $appliedImmediately,
            $recurringPrice
        );

        $this->comparePrice($subscriptionCalculatePackageChangeResponse->getPrice(), $price);
        $this->comparePrice($subscriptionCalculatePackageChangeResponse->getRecurringPrice(), $recurringPrice);
        $this->assertEquals($needsBilling, $subscriptionCalculatePackageChangeResponse->isNeedsBilling());
        $this->assertEquals($appliedImmediately, $subscriptionCalculatePackageChangeResponse->isAppliedImmediately());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $price = PriceMock::create();
        $recurringPrice = PriceMock::create();

        $response = [
            'needsBilling'       => MockHelper::getFaker()->boolean(),
            'appliedImmediately' => MockHelper::getFaker()->boolean(),
            'price'              => $price->toArray(),
            'recurringPrice'     => $recurringPrice->toArray(),
        ];

        $subscriptionCalculatePackageChangeResponse = SubscriptionCalculatePackageChangeResponse::fromResponse($response);

        $this->comparePrice($subscriptionCalculatePackageChangeResponse->getPrice(), $price);
        $this->comparePrice($subscriptionCalculatePackageChangeResponse->getRecurringPrice(), $recurringPrice);
        $this->assertEquals($response['needsBilling'], $subscriptionCalculatePackageChangeResponse->isNeedsBilling());
        $this->assertEquals($response['appliedImmediately'], $subscriptionCalculatePackageChangeResponse->isAppliedImmediately());
    }

}