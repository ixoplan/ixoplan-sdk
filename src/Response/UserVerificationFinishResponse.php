<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserVerificationFinishResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\UserVerificationFinishResponseObject instead
 */
class UserVerificationFinishResponse {

    /**
     * @var User|null
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user = null) {
        $this->user = $user;
    }

    /**
     * @return User|null
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
        return new self(!empty($response['user']) ? User::fromResponse($response['user']) : null);
    }

}