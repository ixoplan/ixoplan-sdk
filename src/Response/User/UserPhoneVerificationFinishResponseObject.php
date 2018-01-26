<?php

namespace Ixolit\Dislo\Response\User;


use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class UserPhoneVerificationFinishResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserPhoneVerificationFinishResponseObject {

    /**
     * @var UserObject|null
     */
    private $user;

    /**
     * @var \DateTime|null
     */
    private $verifiedAt;

    /**
     * @param UserObject|null      $user
     * @param \DateTime|null $verifiedAt
     */
    public function __construct(UserObject $user = null, \DateTime $verifiedAt = null) {
        $this->user       = $user;
        $this->verifiedAt = $verifiedAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getVerifiedAt() {
        return $this->verifiedAt;
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
     * @return UserPhoneVerificationFinishResponseObject
     */
    public static function fromResponse(array $response) {
        return new self(
            isset($response['user'])
                ? UserObject::fromResponse($response['user'])
                : null,
            !empty($response['verifiedAt'])
                ? new \DateTime($response['verifiedAt'])
                : null
        );
    }

}