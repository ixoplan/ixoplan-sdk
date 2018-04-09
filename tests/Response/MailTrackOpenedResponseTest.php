<?php

use Ixolit\Dislo\Response\MailTrackOpenedResponse;
use Ixolit\Dislo\Test\AbstractTestCase;

/**
 * Class MailTrackOpenedResponseTest
 */
class MailTrackOpenedResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $response = [];

        $mailTrackOpenedResponse = MailTrackOpenedResponse::fromResponse($response);

        $this->assertInstanceOf(MailTrackOpenedResponse::class, $mailTrackOpenedResponse);
    }

}