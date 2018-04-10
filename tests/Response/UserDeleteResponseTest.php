<?php

use Ixolit\Dislo\Response\UserDeleteResponse;
use Ixolit\Dislo\Test\AbstractTestCase;

/**
 * Class UserDeleteResponseTest
 */
class UserDeleteResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $userDeleteResponse = UserDeleteResponse::fromResponse([]);

        $this->assertInstanceOf(UserDeleteResponse::class, $userDeleteResponse);
    }

}