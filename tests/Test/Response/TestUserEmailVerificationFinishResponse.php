<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class TestUserEmailVerificationFinishResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserEmailVerificationFinishResponse implements TestResponseInterface {

    /**
     * @var UserObject|null
     */
    private $user;

    /**
     * TestUserEmailVerificationFinishResponse constructor.
     */
    public function __construct() {
        $this->user = UserMock::create(false);
    }

    /**
     * @return UserObject|null
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'user' => $this->getUser()->toArray(),
        ];
    }
}