<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\BillingEvent;

/**
 * Class BillingEventMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class BillingEventMock {

    /**
     * @var string[]
     */
    protected static $types = [
        BillingEvent::TYPE_AUTHORIZE,
        BillingEvent::TYPE_CHARGE,
        BillingEvent::TYPE_CHARGEBACK,
        BillingEvent::TYPE_REFUND,
    ];

    /**
     * @var string[]
     */
    protected static $states = [
        BillingEvent::STATUS_SUCCESS,
        BillingEvent::STATUS_REQUESTED,
        BillingEvent::STATUS_ERROR,
    ];

    /**
     * @param string|null $type
     * @param string|null $status
     *
     * @return BillingEvent
     */
    public static function create($type = null, $status = null) {
        $billingMethod = BillingMethodMock::create(true);

        return new BillingEvent(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->randomFloat(2),
            MockHelper::getFaker()->dateTime(),
            \in_array($type, self::$types)
                ? $type
                : self::randomType(),
            \in_array($status, self::$states)
                ? $status
                : self::randomStatus(),
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->word,
            $billingMethod->getName(),
            SubscriptionMock::create(),
            MockHelper::getFaker()->dateTime(),
            $billingMethod
        );
    }

    /**
     * @return string
     */
    public static function randomType() {
        return self::$types[\rand(0, (\count(self::$types) - 1))];
    }

    /**
     * @return string
     */
    public static function randomStatus() {
        return self::$states[\rand(0,(\count(self::$states) - 1))];
    }

}