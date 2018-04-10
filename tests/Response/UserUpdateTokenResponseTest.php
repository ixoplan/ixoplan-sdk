<?php

use Ixolit\Dislo\Response\UserUpdateTokenResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\AuthTokenMock;

/**
 * Class UserUpdateTokenResponseTest
 */
class UserUpdateTokenResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $authToken = AuthTokenMock::create();

        $userUpdateTokenResponse = new UserUpdateTokenResponse($authToken);

        $reflectionObject = new \ReflectionObject($userUpdateTokenResponse);

        $authTokenProperty = $reflectionObject->getProperty('authToken');
        $authTokenProperty->setAccessible(true);
        $this->compareAuthToken($authTokenProperty->getValue($userUpdateTokenResponse), $authToken);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $authToken = AuthTokenMock::create();

        $userUpdateTokenResponse = new UserUpdateTokenResponse($authToken);

        $this->compareAuthToken($userUpdateTokenResponse->getAuthToken(), $authToken);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $authToken = AuthTokenMock::create();

        $response = [
            'authToken' => $authToken->toArray(),
        ];

        $userUpdateTokenResponse = UserUpdateTokenResponse::fromResponse($response);

        $this->compareAuthToken($userUpdateTokenResponse->getAuthToken(), $authToken);
    }

}