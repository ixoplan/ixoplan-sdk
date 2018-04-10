<?php

use Ixolit\Dislo\Response\UserEmailVerificationFinishResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserEmailVerificationFinishResponseTest
 */
class UserEmailVerificationFinishResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();

        $response = [
            'user' => $user->toArray(),
        ];

        $userEmailVerificationFinishResponse = UserEmailVerificationFinishResponse::fromResponse($response);

        $this->compareUser($userEmailVerificationFinishResponse->getUser(), $user);
    }

}