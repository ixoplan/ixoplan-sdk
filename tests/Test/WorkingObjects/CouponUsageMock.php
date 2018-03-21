<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\CouponUsage;

/**
 * Class CouponUsageMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class CouponUsageMock {

    /**
     * @return CouponUsage
     */
    public static function create() {
        return new CouponUsage(
            CouponMock::create(),
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime()
        );
    }

}