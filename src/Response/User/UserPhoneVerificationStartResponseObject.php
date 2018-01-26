<?php

namespace Ixolit\Dislo\Response\User;


/**
 * Class UserPhoneVerificationStartResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserPhoneVerificationStartResponseObject {

    /**
     * @param array $response
     *
     * @return UserPhoneVerificationStartResponseObject
     */
    public static function fromResponse($response) {
        return new self();
    }

}