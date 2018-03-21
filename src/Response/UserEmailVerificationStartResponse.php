<?php

namespace Ixolit\Dislo\Response;

/**
 * Class UserEmailVerificationStartResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserEmailVerificationStartResponse extends UserVerificationStartResponse {

    /**
     * @param $response
     *
     * @return UserEmailVerificationStartResponse
     */
    public static function fromResponse($response) {
        return new self();
    }

}