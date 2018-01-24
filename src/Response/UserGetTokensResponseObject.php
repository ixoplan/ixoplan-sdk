<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\AuthTokenObject;

/**
 * Class UserGetTokensResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserGetTokensResponseObject {

    /**
     * @var AuthTokenObject[]
     */
    private $tokens;

    /**
     * @param AuthTokenObject[] $tokens
     */
    public function __construct(array $tokens) {
        $this->tokens = $tokens;
    }

    /**
     * @return AuthTokenObject[]
     */
    public function getTokens() {
        return $this->tokens;
    }

    /**
     * @param array $response
     *
     * @return UserGetTokensResponseObject
     */
    public static function fromResponse($response) {
        $tokens = [];
        foreach ($response['authTokens'] as $authTokenDefinition) {
            $tokens[] = AuthTokenObject::fromResponse($authTokenDefinition);
        }
        return new self($tokens);
    }

}