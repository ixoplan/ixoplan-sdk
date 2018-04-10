<?php

use Ixolit\Dislo\Response\UserChangeResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserChangeResponseTest
 */
class UserChangeResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();

        $userChangeResponse = new UserChangeResponse($user);

        $reflectionObject = new \ReflectionObject($userChangeResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userChangeResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();

        $userChangeResponse = new UserChangeResponse($user);

        $this->compareUser($userChangeResponse->getUser(), $user);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userChangeResponse = UserChangeResponse::fromResponse($response);

        $this->compareUser($userChangeResponse->getUser(), $user);
    }

}