<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class TestUserChangePasswordResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserChangePasswordResponse implements TestResponseInterface {

    /**
     * @var UserObject
     */
    private $user;

    /**
     * TestUserChangePasswordResponse constructor.
     */
    public function __construct() {
        $this->user = UserMock::create();
    }

    /**
     * @return UserObject
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