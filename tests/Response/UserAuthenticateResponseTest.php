<?php

use Ixolit\Dislo\Response\UserAuthenticateResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserAuthenticateResponseTest
 */
class UserAuthenticateResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $user = UserMock::create();
        $authToken = MockHelper::getFaker()->uuid;

        $userAuthenticateResponse = new UserAuthenticateResponse($user, $authToken);

        $reflectionObject = new \ReflectionObject($userAuthenticateResponse);

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userAuthenticateResponse), $user);

        $authTokenProperty = $reflectionObject->getProperty('authToken');
        $authTokenProperty->setAccessible(true);
        $this->assertEquals($authToken, $authTokenProperty->getValue($userAuthenticateResponse));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $user = UserMock::create();
        $authToken = MockHelper::getFaker()->uuid;

        $userAuthenticateResponse = new UserAuthenticateResponse($user, $authToken);

        $this->compareUser($userAuthenticateResponse->getUser(), $user);
        $this->assertEquals($authToken, $userAuthenticateResponse->getAuthToken());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
            'authToken' => MockHelper::getFaker()->uuid,
        ];

        $userAuthenticateResponse = UserAuthenticateResponse::fromResponse($response);

        $this->compareUser($userAuthenticateResponse->getUser(), $user);
        $this->assertEquals($response['authToken'], $userAuthenticateResponse->getAuthToken());
    }

}