<?php

use Ixolit\Dislo\Response\UserCreateResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserCreateResponseTest
 */
class UserCreateResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();

        $userCreateResponse = new UserCreateResponse($user);

        $reflectionObject = new \ReflectionObject($userCreateResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userCreateResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();

        $userCreateResponse = new UserCreateResponse($user);

        $this->compareUser($userCreateResponse->getUser(), $user);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userCreateResponse = UserCreateResponse::fromResponse($response);

        $this->compareUser($userCreateResponse->getUser(), $user);
    }

}