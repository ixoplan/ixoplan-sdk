<?php

use Ixolit\Dislo\Response\UserDisableLoginResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserDisableLoginResponseTest
 */
class UserDisableLoginResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();

        $userDisableLoginResponse = new UserDisableLoginResponse($user);

        $reflectionObject = new \ReflectionObject($userDisableLoginResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userDisableLoginResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();

        $userDisableLoginResponse = new UserDisableLoginResponse($user);

        $this->compareUser($userDisableLoginResponse->getUser(), $user);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userDisableLoginResponse = UserDisableLoginResponse::fromResponse($response);

        $this->compareUser($userDisableLoginResponse->getUser(), $user);
    }

}