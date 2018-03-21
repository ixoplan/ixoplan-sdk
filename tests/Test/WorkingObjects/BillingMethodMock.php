<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\BillingMethod;

/**
 * Class BillingMethodMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class BillingMethodMock {

    /**
     * @param bool|null $available
     *
     * @return BillingMethod
     */
    public static function create($available = null) {
        return new BillingMethod(
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