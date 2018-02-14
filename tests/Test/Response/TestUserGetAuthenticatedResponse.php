<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class TestUserGetAuthenticatedResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserGetAuthenticatedResponse implements TestResponseInterface {

    /**
     * @var UserObject
     */
    private $user;

    /**
     * TestUserGetAuthenticatedResponse constructor.
     */
    public function __construct() {
        $this->user = UserMock::create(true);
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