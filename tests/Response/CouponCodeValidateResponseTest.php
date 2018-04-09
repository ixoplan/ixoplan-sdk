<?php

use Ixolit\Dislo\Response\CouponCodeValidateResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\CouponMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;

/**
 * Class CouponCodeValidateResponseTest
 */
class CouponCodeValidateResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $couponCode = MockHelper::getFaker()->uuid;
        $event = CouponMock::randomEvent();
        $valid = MockHelper::getFaker()->boolean();
        $reason = CouponMock::randomReason();
        $discountedPrice = PriceMock::create();
        $recurringPrice = PriceMock::create();

        $couponCodeValidateResponse = new CouponCodeValidateResponse(
            $valid,
            $reason,
            $couponCode,
            $event,
            $discountedPrice,
            $recurringPrice
        );

        $reflectionObject = new \ReflectionObject($couponCodeValidateResponse);

        $discountedPriceProperty = $reflectionObject->getProperty('discountedPrice');
        $discountedPriceProperty->setAccessible(true);
        $this->comparePrice($discountedPriceProperty->getValue($couponCodeValidateResponse), $discountedPrice);

        $recurringPriceProperty = $reflectionObject->getProperty('recurringPrice');
        $recurringPriceProperty->setAccessible(true);
        $this->comparePrice($recurringPriceProperty->getValue($couponCodeValidateResponse), $recurringPrice);

        $reflectionObject = $reflectionObject->getParentClass();

        $validProperty = $reflectionObject->getProperty('valid');
        $validProperty->setAccessible(true);
        $this->assertEquals($valid, $validProperty->getValue($couponCodeValidateResponse));

        $eventProperty = $reflectionObject->getProperty('event');
        $eventProperty->setAccessible(true);
        $this->assertEquals($event, $eventProperty->getValue($couponCodeValidateResponse));

        $couponCodeProperty = $reflectionObject->getProperty('couponCode');
        $couponCodeProperty->setAccessible(true);
        $this->assertEquals($couponCode, $couponCodeProperty->getValue($couponCodeValidateResponse));

        $reasonProperty = $reflectionObject->getProperty('reason');
        $reasonProperty->setAccessible(true);
        $this->assertEquals($reason, $reasonProperty->getValue($couponCodeValidateResponse));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $couponCode = MockHelper::getFaker()->uuid;
        $event = CouponMock::randomEvent();
        $valid = MockHelper::getFaker()->boolean();
        $reason = CouponMock::randomReason();
        $discountedPrice = PriceMock::create();
        $recurringPrice = PriceMock::create();

        $couponCodeValidateResponse = new CouponCodeValidateResponse(
            $valid,
            $reason,
            $couponCode,
            $event,
            $discountedPrice,
            $recurringPrice
        );

        $this->assertEquals($couponCode, $couponCodeValidateResponse->getCouponCode());
        $this->assertEquals($event, $couponCodeValidateResponse->getEvent());
        $this->assertEquals($valid, $couponCodeValidateResponse->isValid());
        $this->assertEquals($reason, $couponCodeValidateResponse->getReason());
        $this->comparePrice($couponCodeValidateResponse->getDiscountedPrice(), $discountedPrice);
        $this->comparePrice($couponCodeValidateResponse->getRecurringPrice(), $recurringPrice);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $discountedPrice = PriceMock::create();
        $recurringPrice = PriceMock::create();
        $couponCode = MockHelper::getFaker()->uuid;
        $event = CouponMock::randomEvent();

        $response = [
            'valid'           => MockHelper::getFaker()->boolean(),
            'reason'          => CouponMock::randomReason(),
            'discountedPrice' => $discountedPrice->toArray(),
            'recurringPrice'  => $recurringPrice->toArray(),
        ];

        $couponCodeValidateResponse = CouponCodeValidateResponse::fromResponse(
            $response,
            $couponCode,
            $event
        );

        $this->assertEquals($couponCode, $couponCodeValidateResponse->getCouponCode());
        $this->assertEquals($event, $couponCodeValidateResponse->getEvent());
        $this->assertEquals($response['valid'], $couponCodeValidateResponse->isValid());
        $this->assertEquals($response['reason'], $couponCodeValidateResponse->getReason());
        $this->comparePrice($couponCodeValidateResponse->getDiscountedPrice(), $discountedPrice);
        $this->comparePrice($couponCodeValidateResponse->getRecurringPrice(), $recurringPrice);
    }

}