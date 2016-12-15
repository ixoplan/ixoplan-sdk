<?php

namespace Ixolit\Dislo\Response;

class UserEmailVerificationStartResponse {
	/**
	 * @param array $response
	 *
	 * @return UserEmailVerificationStartResponse
	 */
	public static function fromResponse($response) {
		return new UserEmailVerificationStartResponse();
	}
}