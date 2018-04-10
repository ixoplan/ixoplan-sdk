<?php

use Ixolit\Dislo\Response\UserRecoveryFinishResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserRecoveryFinishResponseTest
 */
class UserRecoveryFinishResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();

        $userRecoveryFinishResponse = new UserRecoveryFinishResponse($user);

        $reflectionObject = new \ReflectionObject($userRecoveryFinishResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userRecoveryFinishResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();

        $userRecoveryFinishResponse = new UserRecoveryFinishResponse($user);

        $this->compareUser($userRecoveryFinishResponse->getUser(), $user);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userRecoveryFinishResponse = UserRecoveryFinishResponse::fromResponse($response);

        $this->compareUser($userRecoveryFinishResponse->getUser(), $user);
    }

}