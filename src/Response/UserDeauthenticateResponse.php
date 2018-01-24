<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserDeauthenticateResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\UserDeauthenticateResponseObject instead
 */
class UserDeauthenticateResponse {

	public static function fromResponse($response) {
		return new UserDeauthenticateResponse();
	}

}