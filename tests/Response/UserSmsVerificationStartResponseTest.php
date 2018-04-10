<?php

use Ixolit\Dislo\Response\UserSmsVerificationStartResponse;
use Ixolit\Dislo\Test\AbstractTestCase;

/**
 * Class UserSmsVerificationStartResponseTest
 */
class UserSmsVerificationStartResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $userSmsVerificationStartResponse = UserSmsVerificationStartResponse::fromResponse([]);

        $this->assertInstanceOf(UserSmsVerificationStartResponse::class, $userSmsVerificationStartResponse);
    }

}