<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserEmailVerificationStartResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserEmailVerificationStartResponseObject {

    /**
     * @param array $response
     *
     * @return UserEmailVerificationStartResponseObject
     */
    public static function fromResponse($response) {
        return new self();
    }

}