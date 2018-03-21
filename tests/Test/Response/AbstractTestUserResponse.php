<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class AbstractTestUserResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
abstract class AbstractTestUserResponse {

    /**
     * @var User
     */
    private $user;

    /**
     * @var bool
     */
    private $responseWithoutAuthToken;

    /**
     * TestUserChangeResponse constructor.
     *
     * @param User|null $user
     * @param bool            $responseWithoutAuthToken
     */
    public function __construct(User $user = null, $responseWithoutAuthToken = true) {
        $this->user = $user
            ? $user
            : UserMock::create(false);

        $this->responseWithoutAuthToken = $responseWithoutAuthToken;
    }

    /**
     * @return User
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
     * @return User
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