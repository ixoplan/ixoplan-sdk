<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\AuthToken;

/**
 * Class AuthTokenMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class AuthTokenMock {

    /**
     * @return AuthToken
     */
    public static function create() {
        return new AuthToken(
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