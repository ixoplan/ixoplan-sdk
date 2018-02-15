<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;

/**
 * Class SubscriptionMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class SubscriptionMock {

    /**
     * @var string[]
     */
    protected static $states = [
        SubscriptionObject::STATUS_CLOSED,
        SubscriptionObject::STATUS_PENDING,
        SubscriptionObject::STATUS_RUNNING,
        SubscriptionObject::STATUS_ARCHIVED,
        SubscriptionObject::STATUS_CANCELED,
    ];

    /**
     * @var string[]
     */
    protected static $planChangeTypes = [
        SubscriptionObject::PLAN_CHANGE_IMMEDIATE,
        SubscriptionObject::PLAN_CHANGE_QUEUED,
    ];

    /**
     * @param string|null $state
     * @param bool        $withAddonSubscription
     *
     * @return SubscriptionObject
     */
    public static function create($state = null, $withAddonSubscription = true) {
        $addonSubscriptions = [];
        if ($withAddonSubscription) {
            $addonSubscription = self::create(null, false);

            $addonSubscriptions[$addonSubscription->getSubscriptionId()] = $addonSubscription;
        }

        return new SubscriptionObject(
            MockHelper::getFaker()->uuid,
            PackageMock::create(true),
            MockHelper::getFaker()->randomNumber(),
            \in_array($state, self::$states)
                ? $state
                : self::randomState(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean(),
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            NextPackageMock::create(),
            $addonSubscriptions,
            MockHelper::getFaker()->dateTime(),
            false,
            CouponUsageMock::create(),
            PeriodEventMock::create(),
            MockHelper::getFaker()->randomFloat(2)
        );
    }

    /**
     * @return string
     */
    public static function randomState() {
        return self::$states[\rand(0, \count(self::$states) - 1)];
    }

    /**
     * @return string
     */
    public static function randomPlanChangeType() {
        return self::$planChangeTypes[\rand(0, \count(self::$planChangeTypes) - 1)];
    }

}