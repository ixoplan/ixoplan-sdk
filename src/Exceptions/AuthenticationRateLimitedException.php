<?php

namespace Ixolit\Dislo\Exceptions;

class AuthenticationRateLimitedException extends AuthenticationException {
	public function __construct($username) {
		parent::__construct($username, 'rate limited');
	}
}