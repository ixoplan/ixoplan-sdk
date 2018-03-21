<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\AuthToken;
use Ixolit\Dislo\WorkingObjects\User;

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
     * @return User
     */
    public static function create($withAuthToken = null, $loginDisabled = null) {
        return new User(
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
     * @param User           $user
     * @param AuthToken|null $authToken
     *
     * @return User
     */
    public static function changeAuthToken(User $user, AuthToken $authToken = null) {
        return new User(
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
     * @param User  $user
     * @param array $metaData
     *
     * @return User
     */
    public static function changeUserMetaData(User $user, $metaData = []) {
        return new User(
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
     * @param User $user
     * @param bool $loginDisabled
     *
     * @return User
     */
    public static function changeUserIsLoginDisabled(User $user, $loginDisabled) {
        return new User(
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