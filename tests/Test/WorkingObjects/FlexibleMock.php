<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Billing\FlexibleObject;

/**
 * Class FlexibleMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class FlexibleMock {

    /**
     * @var array
     */
    protected static $states = [
        FlexibleObject::STATUS_ACTIVE,
        FlexibleObject::STATUS_PENDING,
        FlexibleObject::STATUS_CLOSED,
    ];

    /**
     * @param string|null $status
     *
     * @return FlexibleObject
     */
    public static function create($status = null) {
        $billingMethod = BillingMethodMock::create();

        return new FlexibleObject(
            MockHelper::getFaker()->randomNumber(),
            (
                    \is_null($status)
                    && \in_array($status, [
                        FlexibleObject::STATUS_ACTIVE,
                        FlexibleObject::STATUS_PENDING,
                        FlexibleObject::STATUS_CLOSED,
                    ])
                )
                ? self::randomStatus()
                : $status,
            [],
            MockHelper::getFaker()->dateTime(),
            $billingMethod->getName(),
            $billingMethod
        );
    }

    /**
     * @return string
     */
    protected static function randomStatus() {
        return self::$states[\rand(0, (\count(self::$states) -1))];
    }

}