<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Billing\ExternalProfileObject;

/**
 * Class ExternalProfileMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class ExternalProfileMock {

    /**
     * @return ExternalProfileObject
     */
    public static function create() {
        return new ExternalProfileObject(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->randomNumber(),
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->uuid
        );
    }

}