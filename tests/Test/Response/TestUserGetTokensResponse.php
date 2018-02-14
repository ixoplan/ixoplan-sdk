<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\AuthTokenMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\User\AuthTokenObject;

/**
 * Class TestUserGetTokensResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserGetTokensResponse implements TestResponseInterface {

    /**
     * @var AuthTokenObject[]
     */
    private $tokens;

    /**
     * TestUserGetTokensResponse constructor.
     */
    public function __construct() {
        $authTokensCount = MockHelper::getFaker()->numberBetween(1, 5);

        for ($i = 0; $i < $authTokensCount; $i++) {
            $authToken = AuthTokenMock::create();

            $this->tokens[$authToken->getToken()] = $authToken;
        }
    }

    /**
     * @return AuthTokenObject[]
     */
    public function getTokens() {
        return $this->tokens;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        $authTokens = [];
        foreach ($this->getTokens() as $token) {
            $authTokens[] = $token->toArray();
        }

        return [
            'authTokens' => $authTokens,
        ];
    }
}