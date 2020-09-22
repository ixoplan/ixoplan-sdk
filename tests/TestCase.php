<?php

namespace Ixolit\Dislo;

use Faker\Factory;
use Faker\Generator;
use Mockery;
use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class TestCase
 *
 * @package Ixolit\Dislo
 */
abstract class TestCase extends BaseTestCase
{
    private $faker;

    /**
     * @return Generator
     */
    protected function getFaker()
    {
        if (!$this->faker) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }

    protected function tearDown()
    {
        Mockery::close();

        parent::tearDown();
    }
}
