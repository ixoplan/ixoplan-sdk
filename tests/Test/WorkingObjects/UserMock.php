<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class UserMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class UserMock {

    /**
     * @param bool|null $withAuthToken
     *
     * @return UserObject
     */
    public static function create($withAuthToken = null) {
        return new UserObject(
            MockHelper::getFaker()->randomNumber(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->languageCode,
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->ipv4,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->currencyCode,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word
            ],
            (!\is_null($withAuthToken) && $withAuthToken === false)
                ? null
                : AuthTokenMock::create()
        );
    }

}