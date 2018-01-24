<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\UserObject;

/**
 * Class UserFindResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserFindResponseObject {

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
     * @return UserFindResponseObject
     */
    public static function fromResponse($response) {
        return new self(UserObject::fromResponse($response['user']));
    }

}