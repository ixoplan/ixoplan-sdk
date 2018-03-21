<?php

namespace Ixolit\Dislo\Test\Response;

/**
 * Class TestUserPhoneVerificationStartResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserPhoneVerificationStartResponse implements TestResponseInterface {

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