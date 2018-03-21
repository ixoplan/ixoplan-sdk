<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Coupon;

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
        Coupon::COUPON_EVENT_START,
        Coupon::COUPON_EVENT_UPGRADE,
    ];

    /**
     * @return Coupon
     */
    public static function create() {
        return new Coupon(
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