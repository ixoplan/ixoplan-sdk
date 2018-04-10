<?php

use Ixolit\Dislo\Response\UserGetResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserGetResponseTest
 */
class UserGetResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();

        $userGetResponse = new UserGetResponse($user);

        $reflectionObject = new \ReflectionObject($userGetResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userGetResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();

        $userGetResponse = new UserGetResponse($user);

        $this->compareUser($userGetResponse->getUser(), $user);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userGetResponse = UserGetResponse::fromResponse($response);

        $this->compareUser($userGetResponse->getUser(), $user);
    }

}