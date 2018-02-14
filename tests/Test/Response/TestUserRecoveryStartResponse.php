<?php

namespace Ixolit\Dislo\Test\Response;


/**
 * Class TestUserRecoveryStartResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserRecoveryStartResponse implements TestResponseInterface {

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