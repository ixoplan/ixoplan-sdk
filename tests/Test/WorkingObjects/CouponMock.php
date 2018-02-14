<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Subscription\CouponObject;

/**
 * Class CouponMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class CouponMock {

    /**
     * @var string[]
     */
    protected static $events = [
        CouponObject::COUPON_EVENT_START,
        CouponObject::COUPON_EVENT_UPGRADE,
    ];

    /**
     * @return CouponObject
     */
    public static function create() {
        return new CouponObject(
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->words()
        );
    }

    /**
     * @return string
     */
    public static function randomEvent() {
        return self::$events[\rand(0, (\count(self::$events) - 1))];
    }

}