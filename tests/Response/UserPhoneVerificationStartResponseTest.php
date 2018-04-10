<?php

use Ixolit\Dislo\Response\UserPhoneVerificationStartResponse;
use Ixolit\Dislo\Test\AbstractTestCase;

/**
 * Class UserPhoneVerificationStartResponseTest
 */
class UserPhoneVerificationStartResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $userPhoneVerificationStartResponse = UserPhoneVerificationStartResponse::fromResponse([]);

        $this->assertInstanceOf(UserPhoneVerificationStartResponse::class, $userPhoneVerificationStartResponse);
    }

}