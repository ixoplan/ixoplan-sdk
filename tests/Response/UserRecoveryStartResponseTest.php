<?php

use Ixolit\Dislo\Response\UserRecoveryStartResponse;
use Ixolit\Dislo\Test\AbstractTestCase;

/**
 * Class UserRecoveryStartResponseTest
 */
class UserRecoveryStartResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $userRecoveryStartResponse = UserRecoveryStartResponse::fromResponse([]);

        $this->assertInstanceOf(UserRecoveryStartResponse::class, $userRecoveryStartResponse);
    }

}