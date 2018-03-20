<?php

namespace Ixolit\Dislo\Response;

/**
 * Class UserDeauthenticateResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserDeauthenticateResponse {

    /**
     * @param array $response
     *
     * @return UserDeauthenticateResponse
     */
	public static function fromResponse($response) {
		return new UserDeauthenticateResponse();
	}

}