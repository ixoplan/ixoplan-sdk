<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class TestUserDisableLoginResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserDisableLoginResponse extends AbstractTestUserResponse implements TestResponseInterface {

    /**
     * TestUserDisableLoginResponse constructor.
     *
     * @param User|null $user
     */
    public function __construct(User $user = null) {
        parent::__construct(
            $user
                ? $user
                : UserMock::create(false, false)
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
            'user' => UserMock::changeUserIsLoginDisabled($this->getResponseUser(), true)->toArray(),
        ];
    }

}