<?php

use Ixolit\Dislo\Response\UserFindResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserFindResponseTest
 */
class UserFindResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();

        $userFindResponse = new UserFindResponse($user);

        $reflectionObject = new \ReflectionObject($userFindResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userFindResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();

        $userFindResponse = new UserFindResponse($user);

        $this->compareUser($userFindResponse->getUser(), $user);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userFindResponse = UserFindResponse::fromResponse($response);

        $this->compareUser($userFindResponse->getUser(), $user);
    }

}