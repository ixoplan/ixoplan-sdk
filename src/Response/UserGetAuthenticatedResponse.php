<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\User;


/**
 * Class UserGetAuthenticatedResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\UserGetAuthenticatedResponseObject instead
 */
class UserGetAuthenticatedResponse {

    /** @var User */
    private $user;

    /**
     * UserGetAuthenticatedResponse constructor.
     *
     * @param User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param array $response
     *
     * @return UserGetAuthenticatedResponse
     */
    public static function fromResponse($response) {
        return new self(User::fromResponse($response['user']));
    }

}