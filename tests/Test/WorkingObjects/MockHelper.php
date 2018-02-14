<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Faker\Factory;


/**
 * Class MockHelper
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class MockHelper {

    /**
     * @var \Faker\Generator
     */
    private static $faker;

    /**
     * @return \Faker\Generator
     */
    public static function getFaker() {
        if (!isset(self::$faker)) {
            self::$faker = Factory::create();
        }

        return self::$faker;
    }

}