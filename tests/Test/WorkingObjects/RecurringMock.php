<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Faker\Factory;
use Ixolit\Dislo\WorkingObjects\Billing\RecurringObject;

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
        RecurringObject::STATUS_CANCELED,
        RecurringObject::STATUS_PENDING,
        RecurringObject::STATUS_CLOSED,
        RecurringObject::STATUS_ACTIVE,
    ];

    /**
     * @return RecurringObject
     */
    public static function create() {
        return new RecurringObject(
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
    protected static function randomStatus() {
        return self::$states[\rand(0, (\count(self::$states) - 1))];
    }

}