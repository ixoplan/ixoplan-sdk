<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserVerificationFinishResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserVerificationFinishResponse {

    /**
     * @var User
     */
    private $user;

    /**
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
     * @return UserEmailVerificationFinishResponse
     */
    public static function fromResponse($response) {
        return new self(User::fromResponse($response['user']));
    }

}