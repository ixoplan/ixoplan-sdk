<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class TestUserGetAuthenticatedResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserGetAuthenticatedResponse extends AbstractTestUserResponse implements TestResponseInterface {

    /**
     * TestUserGetAuthenticatedResponse constructor.
     *
     * @param UserObject|null $user
     */
    public function __construct(UserObject $user = null) {
        parent::__construct(
            $user
                ? $user
                : UserMock::create(true),
            false
        );
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'user' => $this->getResponseUser()->toArray(),
        ];
    }

}