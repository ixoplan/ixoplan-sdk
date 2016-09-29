<?php

namespace Ixolit\Dislo\Exceptions;

class AuthenticationInvalidCredentialsException extends AuthenticationException {
	public function __construct($username) {
		parent::__construct($username, 'invalid credentials');
	}
}