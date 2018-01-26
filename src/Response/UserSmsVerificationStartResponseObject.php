<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserSmsVerificationStartResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserSmsVerificationStartResponseObject {

    /**
     * @param array $response
     *
     * @return UserSmsVerificationStartResponseObject
     */
    public static function fromResponse($response) {
        return new self();
    }

}