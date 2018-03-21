<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class TestUserRecoveryFinishResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserRecoveryFinishResponse extends AbstractTestUserResponse implements TestResponseInterface {

    /**
     * TestUserRecoveryFinishResponse constructor.
     *
     * @param User|null $user
     */
    public function __construct(User $user = null) {
        parent::__construct(
            $user
                ? $user
                : UserMock::create(false)
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