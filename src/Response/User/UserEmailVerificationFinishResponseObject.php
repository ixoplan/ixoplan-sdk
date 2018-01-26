<?php

namespace Ixolit\Dislo\Response\User;


use Ixolit\Dislo\WorkingObjects\UserObject;

/**
 * Class UserEmailVerificationFinishResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserEmailVerificationFinishResponseObject {

    /**
     * @var UserObject|null
     */
    private $user;

    /**
     * @param UserObject $user
     */
    public function __construct(UserObject $user = null) {
        $this->user = $user;
    }

    /**
     * @return UserObject|null
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param array $response
     *
     * @return UserEmailVerificationFinishResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            !empty($response['user'])
                ? UserObject::fromResponse($response['user'])
                : null
        );
    }

}