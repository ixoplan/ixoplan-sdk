<?php

namespace Ixolit\Dislo\Test\Response;


/**
 * Class TestUserSmsVerificationStartResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserSmsVerificationStartResponse implements TestResponseInterface {

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [];
    }

}