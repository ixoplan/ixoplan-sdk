<?php

namespace Ixolit\Dislo\Response;

class UserDeleteResponse {
	public static function fromResponse($response) {
		return new UserDeleteResponse();
	}
}