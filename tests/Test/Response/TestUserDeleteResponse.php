<?php

namespace Ixolit\Dislo\Test\Response;


/**
 * Class TestUserDeleteResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserDeleteResponse implements TestResponseInterface {

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