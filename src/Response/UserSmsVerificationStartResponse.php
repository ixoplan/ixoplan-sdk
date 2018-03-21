<?php

namespace Ixolit\Dislo\Response;

/**
 * Class UserSmsVerificationResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserSmsVerificationStartResponse extends UserVerificationStartResponse {

    /**
     * @param array $response
     *
     * @return UserSmsVerificationStartResponse
     */
    public static function fromResponse($response) {
        return new self();
    }

}