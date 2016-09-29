<?php

namespace Ixolit\Dislo\Response;

class UserDeauthenticateResponse {
	public static function fromResponse($response) {
		return new UserDeauthenticateResponse();
	}
}