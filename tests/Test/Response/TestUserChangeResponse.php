<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class TestUserChangeResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserChangeResponse extends AbstractTestUserResponse implements TestResponseInterface {

    /**
     * TestUserChangeResponseExtends constructor.
     *
     * @param UserObject|null $user
     */
    public function __construct(UserObject $user = null) {
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
            'user' => UserMock::changeUserMetaData($this->getResponseUser(), $data['metaData'])->toArray(),
        ];
    }
}