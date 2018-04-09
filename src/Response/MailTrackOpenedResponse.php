<?php

namespace Ixolit\Dislo\Response;


/**
 * Class MailTrackOpenedResponse
 *
 * @package Ixolit\Dislo\Response
 */
class MailTrackOpenedResponse {

    /**
     * @param array $response
     *
     * @return MailTrackOpenedResponse
     */
	public static function fromResponse($response) {
		return new MailTrackOpenedResponse();
	}

}