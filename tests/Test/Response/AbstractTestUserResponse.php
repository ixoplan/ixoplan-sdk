<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class AbstractTestUserResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
abstract class AbstractTestUserResponse {

    /**
     * @var UserObject
     */
    private $user;

    /**
     * @var bool
     */
    private $responseWithoutAuthToken;

    /**
     * TestUserChangeResponse constructor.
     *
     * @param UserObject|null $user
     * @param bool            $responseWithoutAuthToken
     */
    public function __construct(UserObject $user = null, $responseWithoutAuthToken = true) {
        $this->user = $user
            ? $user
            : UserMock::create(false);

        $this->responseWithoutAuthToken = $responseWithoutAuthToken;
    }

    /**
     * @return UserObject
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function isResponseWithoutAuthToken() {
        return $this->responseWithoutAuthToken;
    }

    /**
     * @return UserObject
     */
    public function getResponseUser() {
        $user = $this->getUser();

        if (!$user) {
            return $user;
        }

        return $this->isResponseWithoutAuthToken()
            ? UserMock::changeAuthToken($user, null)
            : $user;
    }

}