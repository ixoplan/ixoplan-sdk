<?php

namespace Ixolit\Dislo\Exceptions;

class AuthenticationException extends DisloException {
	public function __construct($username, $reason = '') {
		parent::__construct('Authentication failed for user ' . $username . ($reason?'. Reason: ' . $reason:''));
	}
}