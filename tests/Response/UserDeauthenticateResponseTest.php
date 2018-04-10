<?php

use Ixolit\Dislo\Response\UserDeauthenticateResponse;
use Ixolit\Dislo\Test\AbstractTestCase;

/**
 * Class UserDeauthenticateResponseTest
 */
class UserDeauthenticateResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $userDeauthenticateResponse = UserDeauthenticateResponse::fromResponse([]);

        $this->assertInstanceOf(UserDeauthenticateResponse::class, $userDeauthenticateResponse);
    }

}