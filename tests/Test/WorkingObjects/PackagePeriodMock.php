<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\PackagePeriod;

/**
 * Class PackagePeriodMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class PackagePeriodMock {

    /**
     * @return PackagePeriod
     */
    public static function create() {
        $price = PriceMock::create((bool)\rand(0, 1));

        return new PackagePeriod(
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