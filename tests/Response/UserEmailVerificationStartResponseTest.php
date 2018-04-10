<?php

use Ixolit\Dislo\Response\UserEmailVerificationStartResponse;
use Ixolit\Dislo\Test\AbstractTestCase;

/**
 * Class UserEmailVerificationStartResponseTest
 */
class UserEmailVerificationStartResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $userEmailVerificationStartResponse = UserEmailVerificationStartResponse::fromResponse([]);

        $this->assertInstanceOf(UserEmailVerificationStartResponse::class, $userEmailVerificationStartResponse);
    }

}