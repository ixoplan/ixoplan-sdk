<?php

use Ixolit\Dislo\Response\UserVerificationFinishResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserVerificationFinishResponseTest
 */
class UserVerificationFinishResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();

        $userVerificationFinishResponse = new UserVerificationFinishResponse($user);

        $reflectionObject = new \ReflectionObject($userVerificationFinishResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userVerificationFinishResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();

        $userVerificationFinishResponse = new UserVerificationFinishResponse($user);

        $this->compareUser($userVerificationFinishResponse->getUser(), $user);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userVerificationFinishResponse = UserVerificationFinishResponse::fromResponse($response);

        $this->compareUser($userVerificationFinishResponse->getUser(), $user);
    }
}