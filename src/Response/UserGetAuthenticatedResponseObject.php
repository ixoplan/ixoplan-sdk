<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\UserObject;

/**
 * Class UserGetAuthenticatedResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserGetAuthenticatedResponseObject {

    /**
     * @var UserObject
     */
    private $user;

    /**
     * UserGetAuthenticatedResponse constructor.
     *
     * @param UserObject $user
     */
    public function __construct(UserObject $user) {
        $this->user = $user;
    }

    /**
     * @return UserObject
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param array $response
     *
     * @return UserGetAuthenticatedResponseObject
     */
    public static function fromResponse($response) {
        return new self(UserObject::fromResponse($response['user']));
    }

}