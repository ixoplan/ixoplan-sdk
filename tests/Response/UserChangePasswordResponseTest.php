<?php

use Ixolit\Dislo\Response\UserChangePasswordResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserChangePasswordResponseTest
 */
class UserChangePasswordResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();

        $userChangePasswordResponse = new UserChangePasswordResponse($user);

        $reflectionObject = new \ReflectionObject($userChangePasswordResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userChangePasswordResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();

        $userChangePasswordResponse = new UserChangePasswordResponse($user);

        $this->compareUser($userChangePasswordResponse->getUser(), $user);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userChangePasswordResponse = UserChangePasswordResponse::fromResponse($response);

        $this->compareUser($userChangePasswordResponse->getUser(), $user);
    }

}