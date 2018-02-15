<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Billing\BillingMethodObject;

/**
 * Class BillingMethodMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class BillingMethodMock {

    /**
     * @param bool|null $available
     *
     * @return BillingMethodObject
     */
    public static function create($available = null) {
        return new BillingMethodObject(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->word,
            \is_null($available)
                ? MockHelper::getFaker()->boolean()
                : $available,
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean()
        );
    }

}