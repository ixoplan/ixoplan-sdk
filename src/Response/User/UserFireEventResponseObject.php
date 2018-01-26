<?php

namespace Ixolit\Dislo\Response\User;


/**
 * Class UserFireEventResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserFireEventResponseObject {

    /**
     * @param array $response
     *
     * @return UserFireEventResponseObject
     */
    public static function fromResponse($response) {
        return new self();
    }

}