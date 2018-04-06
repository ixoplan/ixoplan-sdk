<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Recurring;

/**
 * Class RecurringMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class RecurringMock {

    /**
     * @var string[]
     */
    protected static $states = [
        Recurring::STATUS_CANCELED,
        Recurring::STATUS_PENDING,
        Recurring::STATUS_CLOSED,
        Recurring::STATUS_ACTIVE,
    ];

    /**
     * @return Recurring
     */
    public static function create() {
        return new Recurring(
            MockHelper::getFaker()->uuid,
            self::randomStatus(),
            MockHelper::getFaker()->uuid,
            SubscriptionMock::create(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->randomFloat(2),
            MockHelper::getFaker()->currencyCode,
            BillingMethodMock::create()
        );
    }

    /**
     * @return string
     */
    public static function randomStatus() {
        return self::$states[\rand(0, (\count(self::$states) - 1))];
    }

}