<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\User\AuthTokenObject;

/**
 * Class AuthTokenMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class AuthTokenMock {

    /**
     * @return AuthTokenObject
     */
    public static function create() {
        return new AuthTokenObject(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->word
        );
    }

}