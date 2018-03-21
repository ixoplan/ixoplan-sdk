<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Flexible;

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
        Flexible::STATUS_ACTIVE,
        Flexible::STATUS_PENDING,
        Flexible::STATUS_CLOSED,
    ];

    /**
     * @param string|null $status
     *
     * @return Flexible
     */
    public static function create($status = null) {
        $billingMethod = BillingMethodMock::create();

        return new Flexible(
            MockHelper::getFaker()->uuid,
            (
                    \is_null($status)
                    && \in_array($status, [
                        Flexible::STATUS_ACTIVE,
                        Flexible::STATUS_PENDING,
                        Flexible::STATUS_CLOSED,
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