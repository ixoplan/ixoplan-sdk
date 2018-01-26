<?php

namespace Ixolit\Dislo\Response\User;


/**
 * Class UserRecoveryStartResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserRecoveryStartResponseObject {

    /**
     * @param array $response
     *
     * @return UserRecoveryStartResponseObject
     */
    public static function fromResponse($response) {
        return new self();
    }

}