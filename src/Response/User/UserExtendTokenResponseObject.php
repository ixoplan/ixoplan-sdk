<?php

namespace Ixolit\Dislo\Response\User;


use Ixolit\Dislo\WorkingObjects\User\AuthTokenObject;

/**
 * Class UserExtendTokenResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserExtendTokenResponseObject {

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
     * @return UserExtendTokenResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            AuthTokenObject::fromResponse($response['authToken'])
        );
    }

}