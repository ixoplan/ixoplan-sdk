<?php

namespace Ixolit\Dislo\Response\User;


use Ixolit\Dislo\WorkingObjects\UserObject;

/**
 * Class UserRecoveryFinishResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserRecoveryFinishResponseObject {

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
     * @return UserRecoveryFinishResponseObject
     */
    public static function fromResponse($response) {
        return new self(UserObject::fromResponse($response['user']));
    }

}