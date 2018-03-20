<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\User;


/**
 * Class UserPhoneVerificationFinishResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserPhoneVerificationFinishResponse extends UserVerificationFinishResponse {

    /**
     * @var \DateTime|null
     */
    private $verifiedAt;

    /**
     * @param User|null      $user
     * @param \DateTime|null $verifiedAt
     */
    public function __construct(User $user = null, \DateTime $verifiedAt = null) {
        $this->verifiedAt = $verifiedAt;

        parent::__construct($user);
    }

    /**
     * @param array $response
     *
     * @return self
     */
    public static function fromResponse($response) {
        return new self(
            isset($response['user']) ? User::fromResponse($response['user']) : null,
            !empty($response['verifiedAt']) ? new \DateTime($response['verifiedAt']) : null
        );
    }

    /**
     * @return \DateTime|null
     */
    public function getVerifiedAt() {
        return $this->verifiedAt;
    }

}