<?php

namespace Ixolit\Dislo\Test\Response;


/**
 * Class TestUserFireEventResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserFireEventResponse implements TestResponseInterface {

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