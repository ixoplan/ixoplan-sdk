<?php

use Ixolit\Dislo\Response\UserGetTokensResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\AuthTokenMock;
use Ixolit\Dislo\WorkingObjects\AuthToken;

/**
 * Class UserGetTokensResponseTest
 */
class UserGetTokensResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $token = AuthTokenMock::create();
        $tokens = [
            $token->getId() => $token,
        ];

        $userGetTokensResponse = new UserGetTokensResponse($tokens);

        $reflectionObject = new \ReflectionObject($userGetTokensResponse);

        $tokensProperty = $reflectionObject->getProperty('tokens');
        $tokensProperty->setAccessible(true);

        /** @var AuthToken[] $testTokens */
        $testTokens = $tokensProperty->getValue($userGetTokensResponse);
        foreach ($testTokens as $testToken) {
            if (empty($tokens[$testToken->getId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareAuthToken($testToken, $tokens[$testToken->getId()]);
        }
    }

    /**
     * @return void
     */
    public function testGetters() {
        $token = AuthTokenMock::create();
        $tokens = [
            $token->getId() => $token,
        ];

        $userGetTokensResponse = new UserGetTokensResponse($tokens);

        $testTokens = $userGetTokensResponse->getTokens();
        foreach ($testTokens as $testToken) {
            if (empty($tokens[$testToken->getId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareAuthToken($testToken, $tokens[$testToken->getId()]);
        }
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $token = AuthTokenMock::create();
        $tokens = [
            $token->getId() => $token,
        ];

        $response = [
            'authTokens' => \array_map(
                function($token) {
                    /** @var AuthToken $token */
                    return $token->toArray();
                },
                $tokens
            )
        ];

        $userGetTokensResponse = UserGetTokensResponse::fromResponse($response);

        $testTokens = $userGetTokensResponse->getTokens();
        foreach ($testTokens as $testToken) {
            if (empty($tokens[$testToken->getId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareAuthToken($testToken, $tokens[$testToken->getId()]);
        }
    }

}