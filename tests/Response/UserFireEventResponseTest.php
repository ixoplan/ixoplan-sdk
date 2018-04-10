<?php

use Ixolit\Dislo\Response\UserFireEventResponse;
use Ixolit\Dislo\Test\AbstractTestCase;

/**
 * Class UserFireEventResponseTest
 */
class UserFireEventResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $userFireEventResponse = UserFireEventResponse::fromResponse([]);

        $this->assertInstanceOf(UserFireEventResponse::class, $userFireEventResponse);
    }

}