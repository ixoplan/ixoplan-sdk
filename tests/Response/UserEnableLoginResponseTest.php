<?php

use Ixolit\Dislo\Response\UserEnableLoginResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserEnableLoginResponseTest
 */
class UserEnableLoginResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();

        $userEnableLoginResponse = new UserEnableLoginResponse($user);

        $reflectionObject = new \ReflectionObject($userEnableLoginResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userEnableLoginResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();

        $userEnableLoginResponse = new UserEnableLoginResponse($user);

        $this->compareUser($userEnableLoginResponse->getUser(), $user);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userEnableLoginResponse = UserEnableLoginResponse::fromResponse($response);

        $this->compareUser($userEnableLoginResponse->getUser(), $user);
    }

}