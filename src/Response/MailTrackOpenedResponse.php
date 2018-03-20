<?php

namespace Ixolit\Dislo\Response;

/**
 * @deprecated use Ixolit\Dislo\Response\Misc\MailTrackOpenedResponseObject instead
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