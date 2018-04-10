<?php

use Ixolit\Dislo\Response\UserGetAuthenticatedResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserGetAuthenticatedResponseTest
 */
class UserGetAuthenticatedResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();

        $userGetAuthenticatedResponse = new UserGetAuthenticatedResponse($user);

        $reflectionObject = new \ReflectionObject($userGetAuthenticatedResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userGetAuthenticatedResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();

        $userGetAuthenticatedResponse = new UserGetAuthenticatedResponse($user);

        $this->compareUser($userGetAuthenticatedResponse->getUser(), $user);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userGetAuthenticatedResponse = UserGetAuthenticatedResponse::fromResponse($response);

        $this->compareUser($userGetAuthenticatedResponse->getUser(), $user);
    }
}