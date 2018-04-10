<?php

use Ixolit\Dislo\Response\UserPhoneVerificationFinishResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserPhoneVerificationFinishResponseTest
 */
class UserPhoneVerificationFinishResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();
        $verifiedAt = MockHelper::getFaker()->dateTime();

        $userPhoneVerificationFinishResponse = new UserPhoneVerificationFinishResponse(
            $user,
            $verifiedAt
        );

        $reflectionObject = new \ReflectionObject($userPhoneVerificationFinishResponse);

        $verifiedAtProperty = $reflectionObject->getProperty('verifiedAt');
        $verifiedAtProperty->setAccessible(true);
        $this->assertEquals($verifiedAt, $verifiedAtProperty->getValue($userPhoneVerificationFinishResponse));

        $reflectionObject = $reflectionObject->getParentClass();

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userPhoneVerificationFinishResponse), $user);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();
        $verifiedAt = MockHelper::getFaker()->dateTime();

        $userPhoneVerificationFinishResponse = new UserPhoneVerificationFinishResponse(
            $user,
            $verifiedAt
        );

        $this->assertEquals($verifiedAt, $userPhoneVerificationFinishResponse->getVerifiedAt());
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

        $userPhoneVerificationFinishResponse = UserPhoneVerificationFinishResponse::fromResponse($response);

        $this->compareUser($userPhoneVerificationFinishResponse->getUser(), $user);
        $this->assertEquals($verifiedAt, $userPhoneVerificationFinishResponse->getVerifiedAt());
    }

}