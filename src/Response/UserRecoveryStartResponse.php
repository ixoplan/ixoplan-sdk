<?php

namespace Ixolit\Dislo\Response;

class UserRecoveryStartResponse {
	public function __construct() {
	}

	public static function fromResponse($response) {
		return new UserRecoveryStartResponse();
	}
}