<?php

namespace Ixolit\Dislo\Response;

/**
 * Class UserPhoneVerificationStartResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserPhoneVerificationStartResponse extends UserVerificationStartResponse {

    /**
     * @param $response
     *
     * @return UserPhoneVerificationStartResponse
     */
    public static function fromResponse($response) {
        return new self();
    }

}