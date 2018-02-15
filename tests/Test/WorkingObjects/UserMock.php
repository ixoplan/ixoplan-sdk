<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\User\AuthTokenObject;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class UserMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class UserMock {

    /**
     * @param bool|null $withAuthToken
     * @param bool|null $loginDisabled
     *
     * @return UserObject
     */
    public static function create($withAuthToken = null, $loginDisabled = null) {
        return new UserObject(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->dateTime(),
            !\is_null($loginDisabled)
                ? $loginDisabled
                : MockHelper::getFaker()->boolean(),
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

    /**
     * @param UserObject           $user
     * @param AuthTokenObject|null $authToken
     *
     * @return UserObject
     */
    public static function changeAuthToken(UserObject $user, AuthTokenObject $authToken = null) {
        return new UserObject(
            $user->getUserId(),
            $user->getCreatedAt(),
            $user->isLoginDisabled(),
            $user->getLanguage(),
            $user->getLastLoginDate(),
            $user->getLastLoginIp(),
            $user->getMetaData(),
            $user->getCurrencyCode(),
            $user->getVerifiedData(),
            $authToken
        );
    }

    /**
     * @param UserObject $user
     * @param array      $metaData
     *
     * @return UserObject
     */
    public static function changeUserMetaData(UserObject $user, $metaData = []) {
        return new UserObject(
            $user->getUserId(),
            $user->getCreatedAt(),
            $user->isLoginDisabled(),
            $user->getLanguage(),
            $user->getLastLoginDate(),
            $user->getLastLoginIp(),
            $metaData,
            $user->getCurrencyCode(),
            $user->getVerifiedData(),
            $user->getAuthToken()
        );
    }

    /**
     * @param UserObject $user
     * @param bool       $loginDisabled
     *
     * @return UserObject
     */
    public static function changeUserIsLoginDisabled(UserObject $user, $loginDisabled) {
        return new UserObject(
            $user->getUserId(),
            $user->getCreatedAt(),
            $loginDisabled,
            $user->getLanguage(),
            $user->getLastLoginDate(),
            $user->getLastLoginIp(),
            $user->getMetaData(),
            $user->getCurrencyCode(),
            $user->getVerifiedData(),
            $user->getAuthToken()
        );
    }

}