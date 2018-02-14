<?php

namespace Ixolit\Dislo\Test\Request;


use Ixolit\Dislo\Request\RequestClient;
use Ixolit\Dislo\Test\Response\TestResponseInterface;

/**
 * Class TestRequestClient
 *
 * @package Ixolit\Dislo\FrontendClient
 */
final class TestRequestClient implements RequestClient {

    /**
     * @var array|TestResponseInterface
     */
    private $testResponse;

    /**
     * TestRequestClient constructor.
     *
     * @param array|TestResponseInterface $testResponse
     */
    public function __construct($testResponse) {
        $this->testResponse = $testResponse;
    }

    /**
     * @return array|TestResponseInterface
     */
    private function getTestResponse() {
        return $this->testResponse;
    }

    /**
     * @param string $uri
     * @param array  $params
     *
     * @return array
     */
    public function request($uri, array $params) {
        $response = $this->getTestResponse();

        if ($response instanceof TestResponseInterface) {
            return $response->handleRequest($uri, $params);
        }

        return $response;
    }

}