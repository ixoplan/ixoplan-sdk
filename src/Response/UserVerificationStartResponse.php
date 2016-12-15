<?php

namespace Ixolit\Dislo\Response;

class UserVerificationStartResponse {
	/**
	 * @param array $response
	 *
	 * @return UserVerificationStartResponse
	 */
	public function fromResponse($response) {
		return new UserVerificationStartResponse();
	}
}