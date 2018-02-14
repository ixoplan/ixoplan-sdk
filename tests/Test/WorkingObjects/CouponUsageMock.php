<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Subscription\CouponUsageObject;

/**
 * Class CouponUsageMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class CouponUsageMock {

    /**
     * @return CouponUsageObject
     */
    public static function create() {
        return new CouponUsageObject(
            CouponMock::create(),
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime()
        );
    }

}