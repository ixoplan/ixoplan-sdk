<?php

namespace Ixolit\Dislo\Test\WorkingObjects;

use Ixolit\Dislo\WorkingObjects\ExternalProfile;

/**
 * Class ExternalProfileMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class ExternalProfileMock {

    /**
     * @return ExternalProfile
     */
    public static function create() {
        return new ExternalProfile(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->randomNumber(),
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->uuid
        );
    }

}