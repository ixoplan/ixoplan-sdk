<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Subscription;

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
        Subscription::STATUS_CLOSED,
        Subscription::STATUS_PENDING,
        Subscription::STATUS_RUNNING,
        Subscription::STATUS_ARCHIVED,
        Subscription::STATUS_CANCELED,
    ];

    /**
     * @var string[]
     */
    protected static $planChangeTypes = [
        Subscription::PLAN_CHANGE_IMMEDIATE,
        Subscription::PLAN_CHANGE_QUEUED,
    ];

    /**
     * @param string|null $state
     * @param bool        $withAddonSubscription
     *
     * @return Subscription
     */
    public static function create($state = null, $withAddonSubscription = true) {
        $addonSubscriptions = [];
        if ($withAddonSubscription) {
            $addonSubscription = self::create(null, false);

            $addonSubscriptions[$addonSubscription->getSubscriptionId()] = $addonSubscription;
        }

        return new Subscription(
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