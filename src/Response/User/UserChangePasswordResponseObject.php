<?php

namespace Ixolit\Dislo\Response\User;


use Ixolit\Dislo\WorkingObjects\UserObject;

/**
 * Class UserChangePasswordObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserChangePasswordResponseObject {

    /**
     * @var UserObject
     */
    private $user;

    /**
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
     * @return UserChangePasswordResponseObject
     */
    public static function fromResponse($response) {
        return new self(UserObject::fromResponse($response['user']));
    }

}