<?php

namespace Ixolit\Dislo\Test\Response;

/**
 * Class TestSubscriptionFireEventResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionFireEventResponse implements TestResponseInterface {

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'success' => true,
        ];
    }
}