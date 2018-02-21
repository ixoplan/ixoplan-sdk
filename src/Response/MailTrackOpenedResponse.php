<?php

namespace Ixolit\Dislo\Response;

/**
 * @deprecated use Ixolit\Dislo\Response\Misc\MailTrackOpenedResponseObject instead
 */
class MailTrackOpenedResponse {

	public static function fromResponse($response) {
		return new MailTrackOpenedResponse();
	}
}