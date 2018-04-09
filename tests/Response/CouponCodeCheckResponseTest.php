<?php

use Ixolit\Dislo\Response\CouponCodeCheckResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\CouponMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class CouponCodeCheckResponseTest
 */
class CouponCodeCheckResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $couponCode = MockHelper::getFaker()->uuid;
        $event = CouponMock::randomEvent();
        $valid = MockHelper::getFaker()->boolean();
        $reason = CouponMock::randomReason();

        $couponCodeCheckResponse = new CouponCodeCheckResponse($valid, $reason, $couponCode, $event);

        $reflectionObject = new \ReflectionObject($couponCodeCheckResponse);

        $reflectionObject = $reflectionObject->getParentClass();

        $validProperty = $reflectionObject->getProperty('valid');
        $validProperty->setAccessible(true);
        $this->assertEquals($valid, $validProperty->getValue($couponCodeCheckResponse));

        $reasonProperty = $reflectionObject->getProperty('reason');
        $reasonProperty->setAccessible(true);
        $this->assertEquals($reason, $reasonProperty->getValue($couponCodeCheckResponse));

        $couponCodeProperty = $reflectionObject->getProperty('couponCode');
        $couponCodeProperty->setAccessible(true);
        $this->assertEquals($couponCode, $couponCodeProperty->getValue($couponCodeCheckResponse));

        $eventProperty = $reflectionObject->getProperty('event');
        $eventProperty->setAccessible(true);
        $this->assertEquals($event, $eventProperty->getValue($couponCodeCheckResponse));

        new CouponCodeCheckResponse($valid, $reason, $couponCode);
    }

}