<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Subscription\PeriodEventObject;

/**
 * Class PeriodEventMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class PeriodEventMock {

    /**
     * @return PeriodEventObject
     */
    public static function create() {
        return new PeriodEventObject(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->dateTime(),
            null //to not add subscription, with period event again
        );
    }

}