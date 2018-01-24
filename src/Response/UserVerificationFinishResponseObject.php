<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\UserObject;

/**
 * Class UserVerificationFinishResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserVerificationFinishResponseObject {

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
     * @return UserVerificationFinishResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            !empty($response['user'])
                ? UserObject::fromResponse($response['user'])
                : null
        );
    }

}