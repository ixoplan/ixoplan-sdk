<?php

use Ixolit\Dislo\Response\UserVerificationStartResponse;
use Ixolit\Dislo\Test\AbstractTestCase;

/**
 * Class UserVerificationStartResponseTest
 */
class UserVerificationStartResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $userVerificationStartResponse = UserVerificationStartResponse::fromResponse([]);

        $this->assertInstanceOf(UserVerificationStartResponse::class, $userVerificationStartResponse);
    }

}