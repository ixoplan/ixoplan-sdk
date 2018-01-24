<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\AuthTokenObject;

/**
 * Class UserUpdateTokenResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserUpdateTokenResponseObject {

    /**
     * @var AuthTokenObject
     */
    private $authToken;

    /**
     * @param AuthTokenObject $authToken
     */
    public function __construct(AuthTokenObject $authToken) {
        $this->authToken = $authToken;
    }

    /**
     * @return AuthTokenObject
     */
    public function getAuthToken() {
        return $this->authToken;
    }

    /**
     * @param array $response
     *
     * @return UserUpdateTokenResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            AuthTokenObject::fromResponse($response['authToken'])
        );
    }

}