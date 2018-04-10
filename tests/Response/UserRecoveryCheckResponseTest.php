<?php

use Ixolit\Dislo\Response\UserRecoveryCheckResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class UserRecoveryCheckResponseTest
 */
class UserRecoveryCheckResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $valid = MockHelper::getFaker()->boolean();

        $userRecoveryCheckResponse = new UserRecoveryCheckResponse($valid);

        $reflectionObject = new \ReflectionObject($userRecoveryCheckResponse);

        $validProperty = $reflectionObject->getProperty('valid');
        $validProperty->setAccessible(true);
        $this->assertEquals($valid, $validProperty->getValue($userRecoveryCheckResponse));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $valid = MockHelper::getFaker()->boolean();

        $userRecoveryCheckResponse = new UserRecoveryCheckResponse($valid);

        $this->assertEquals($valid, $userRecoveryCheckResponse->isValid());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $response = [
            'valid' => MockHelper::getFaker()->boolean(),
        ];

        $userRecoveryCheckResponse = UserRecoveryCheckResponse::fromResponse($response);

        $this->assertEquals($response['valid'], $userRecoveryCheckResponse->isValid());
    }

}