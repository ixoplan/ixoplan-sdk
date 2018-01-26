<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserFireEventResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\UserFireEventResponseObject instead
 */
class UserFireEventResponse {

	public static function fromResponse($response) {
		return new UserFireEventResponse();
	}
}