<?php

namespace Ixolit\Dislo\Test\Response;


/**
 * Class TestUserDeauthenticateResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserDeauthenticateResponse implements TestResponseInterface {

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