<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class TestUserSmsVerificationFinishResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserSmsVerificationFinishResponse extends AbstractTestUserResponse implements TestResponseInterface {

    /**
     * @var \DateTime|null
     */
    private $verifiedAt;

    /**
     * TestUserPhoneVerificationFinishResponse constructor.
     */
    public function __construct() {
        $withUser = MockHelper::getFaker()->boolean();

        $this->verifiedAt = $withUser
            ? null
            : MockHelper::getFaker()->dateTime();

        parent::__construct(
            $withUser
                ? UserMock::create(false)
                : null
        );
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

        $user = $this->getResponseUser();

        if ($user) {
            $response['user'] = $user->toArray();
        }
        if ($this->getVerifiedAt()) {
            $response['verifiedAt'] = $this->getVerifiedAt()->format('Y-m-d H:i:s');
        }

        return $response;
    }
}