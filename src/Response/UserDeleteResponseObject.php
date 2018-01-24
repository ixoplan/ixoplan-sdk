<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserDeleteResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserDeleteResponseObject {

    /**
     * @param array $response
     *
     * @return UserDeleteResponseObject
     */
    public static function fromResponse($response) {
        return new self();
    }

}