<?php

use Ixolit\Dislo\Response\UserSmsVerificationFinishResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserSmsVerificationFinishResponseTest
 */
class UserSmsVerificationFinishResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();
        $verifiedAt = MockHelper::getFaker()->dateTime();

        $userSmsVerificationFinishResponse = new UserSmsVerificationFinishResponse(
            $user,
            $verifiedAt
        );

        $reflectionObject = new \ReflectionObject($userSmsVerificationFinishResponse);

        $verifiedAtProperty = $reflectionObject->getProperty('verifiedAt');
        $verifiedAtProperty->setAccessible(true);
        $this->assertEquals($verifiedAt, $verifiedAtProperty->getValue($userSmsVerificationFinishResponse));

        $reflectionObject = $reflectionObject->getParentClass();

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userSmsVerificationFinishResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();
        $verifiedAt = MockHelper::getFaker()->dateTime();

        $userSmsVerificationFinishResponse = new UserSmsVerificationFinishResponse(
            $user,
            $verifiedAt
        );

        $this->assertEquals($verifiedAt, $userSmsVerificationFinishResponse->getVerifiedAt());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();
        $verifiedAt = MockHelper::getFaker()->dateTime();

        $response = [
            'user' => $user->toArray(),
            'verifiedAt' => $verifiedAt->format('Y-m-d H:i:s'),
        ];

        $userSmsVerificationFinishResponse = UserSmsVerificationFinishResponse::fromResponse($response);

        $this->compareUser($userSmsVerificationFinishResponse->getUser(), $user);
        $this->assertEquals($verifiedAt, $userSmsVerificationFinishResponse->getVerifiedAt());
    }

}