<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\AuthTokenMock;
use Ixolit\Dislo\WorkingObjects\AuthToken;

/**
 * Class TestUserUpdateTokenResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserUpdateTokenResponse implements TestResponseInterface {

    /**
     * @var AuthToken
     */
    private $authToken;

    /**
     * TestUserUpdateTokenResponse constructor.
     */
    public function __construct() {
        $this->authToken = AuthTokenMock::create();
    }

    /**
     * @return AuthToken
     */
    public function getAuthToken() {
        return $this->authToken;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'authToken' => $this->getAuthToken()->toArray(),
        ];
    }

}