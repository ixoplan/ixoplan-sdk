<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class TestUserEnableLoginResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserEnableLoginResponse extends AbstractTestUserResponse implements TestResponseInterface {

    /**
     * TestUserEnableLoginResponse constructor.
     *
     * @param UserObject|null $user
     */
    public function __construct(UserObject $user = null) {
        parent::__construct(
            $user
                ? $user
                : UserMock::create(false, true)
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
            'user' => UserMock::changeUserIsLoginDisabled($this->getResponseUser(), false)->toArray(),
        ];
    }
}