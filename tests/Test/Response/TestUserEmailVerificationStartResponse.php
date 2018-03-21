<?php

namespace Ixolit\Dislo\Test\Response;

/**
 * Class TestUserEmailVerificationStartResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserEmailVerificationStartResponse implements TestResponseInterface {

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