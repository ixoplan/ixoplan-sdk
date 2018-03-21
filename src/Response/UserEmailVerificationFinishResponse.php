<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserEmailVerificationFinishResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserEmailVerificationFinishResponse extends UserVerificationFinishResponse {

    /**
     * @param array $response
     *
     * @return UserEmailVerificationFinishResponse
     */
    public static function fromResponse($response) {
        return new self(
            !empty($response['user'])
                ? User::fromResponse($response['user'])
                : null
        );
    }

}