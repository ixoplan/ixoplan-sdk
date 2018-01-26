<?php

namespace Ixolit\Dislo\Response\User;


/**
 * Class UserDeauthenticateResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserDeauthenticateResponseObject {

    /**
     * @param array $response
     *
     * @return UserDeauthenticateResponseObject
     */
    public static function fromResponse($response) {
        return new self();
    }

}