<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class TestUserPhoneVerificationFinishResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserPhoneVerificationFinishResponse implements TestResponseInterface {

    /**
     * @var UserObject|null
     */
    private $user;

    /**
     * @var \DateTime|null
     */
    private $verifiedAt;

    public function __construct() {
        $withUser = MockHelper::getFaker()->boolean();

        $this->user = $withUser
            ? UserMock::create(false)
            : null;

        $this->verifiedAt = $withUser
            ? null
            : MockHelper::getFaker()->dateTime();
    }

    /**
     * @return UserObject|null
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return \DateTime|null
     */
    public function getVerifiedAt() {
        return $this->verifiedAt;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        $response = [];

        if ($this->getUser()) {
            $response['user'] = $this->getUser()->toArray();
        }
        if ($this->getVerifiedAt()) {
            $response['verifiedAt'] = $this->getVerifiedAt()->format('Y-m-d H:i:s');
        }

        return $response;
    }
}