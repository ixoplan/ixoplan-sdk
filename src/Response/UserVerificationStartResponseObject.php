<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserVerificationStartResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserVerificationStartResponseObject {

    /**
     * @param array $response
     *
     * @return UserVerificationStartResponseObject
     */
    public static function fromResponse($response) {
        return new self();
    }

}