<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Subscription\PackagePeriodObject;

/**
 * Class PackagePeriodMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class PackagePeriodMock {

    /**
     * @return PackagePeriodObject
     */
    public static function create() {
        $price = PriceMock::create((bool)\rand(0, 1));

        return new PackagePeriodObject(
            MockHelper::getFaker()->uuid,
            'days',
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            [
                $price->getTag() => $price,
            ],
            MockHelper::getFaker()->randomNumber()
        );
    }

}