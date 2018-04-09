<?php

use Ixolit\Dislo\Response\SubscriptionCalculatePriceResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;

/**
 * Class SubscriptionCalculatePriceResponseTest
 */
class SubscriptionCalculatePriceResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $price = PriceMock::create();
        $recurringPrice = PriceMock::create();

        $subscriptionCalculatePriceResponse = new SubscriptionCalculatePriceResponse($price, $recurringPrice);

        $reflectionObject = new \ReflectionObject($subscriptionCalculatePriceResponse);

        $reflectionObject = $reflectionObject->getParentClass();

        $priceProperty = $reflectionObject->getProperty('price');
        $priceProperty->setAccessible(true);
        $this->comparePrice($priceProperty->getValue($subscriptionCalculatePriceResponse), $price);

        $recurringPriceProperty = $reflectionObject->getProperty('recurringPrice');
        $recurringPriceProperty->setAccessible(true);
        $this->comparePrice($recurringPriceProperty->getValue($subscriptionCalculatePriceResponse), $recurringPrice);

        new SubscriptionCalculatePriceResponse($price);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $price = PriceMock::create();
        $recurringPrice = PriceMock::create();

        $response = [
            'price'          => $price->toArray(),
            'recurringPrice' => $recurringPrice->toArray(),
        ];

        $subscriptionCalculatePriceResponse = SubscriptionCalculatePriceResponse::fromResponse($response);

        $this->comparePrice($subscriptionCalculatePriceResponse->getPrice(), $price);
        $this->comparePrice($subscriptionCalculatePriceResponse->getRecurringPrice(), $recurringPrice);
    }

}