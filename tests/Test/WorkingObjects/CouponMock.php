<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\Response\CouponCodeResponse;
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
     * @var string[]
     */
    protected static $reasons = [
        CouponCodeResponse::REASON_INVALID_CODE,
        CouponCodeResponse::REASON_NOT_VALID_NOW,
        CouponCodeResponse::REASON_INVALID_MISC,
        CouponCodeResponse::REASON_MAX_USAGE_REACHED,
        CouponCodeResponse::REASON_INVALID_EVENT,
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

    /**
     * @return string
     */
    public static function randomReason() {
        return self::$reasons[\rand(0, (\count(self::$reasons) - 1))];
    }

}