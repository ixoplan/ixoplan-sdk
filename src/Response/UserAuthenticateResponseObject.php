<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\UserObject;

/**
 * Class UserAuthenticateResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserAuthenticateResponseObject {

    /**
     * @var UserObject
     */
    private $user;

    /**
     * @var string
     */
    private $authToken;

    /**
     * @param UserObject $user
     * @param string     $authToken
     */
    public function __construct(UserObject $user, $authToken) {
        $this->user      = $user;
        $this->authToken = $authToken;
    }

    /**
     * @return UserObject
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getAuthToken() {
        return $this->authToken;
    }

    /**
     * @param $response
     *
     * @return UserAuthenticateResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            UserObject::fromResponse($response['user']),
            $response['authToken']
        );
    }

}