<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class TestUserCreateResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserCreateResponse extends AbstractTestUserResponse implements TestResponseInterface {

    /**
     * TestUserCreateResponse constructor.
     */
    public function __construct() {
        parent::__construct(UserMock::create(false));
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