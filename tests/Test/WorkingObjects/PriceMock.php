<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Price;

/**
 * Class PriceMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class PriceMock {

    /**
     * @param bool $withCompositePrices
     *
     * @return Price
     */
    public static function create($withCompositePrices = true) {
        $compositePrices = [];
        if ($withCompositePrices) {
            $compositePrice = PriceMock::create(false);

            $compositePrices[$compositePrice->getTag()] = $compositePrice;
        }

        return new Price(
            MockHelper::getFaker()->randomFloat(),
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            $compositePrices
        );
    }

}