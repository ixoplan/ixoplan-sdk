<?php

namespace Ixolit\Dislo\Response;

class UserRecoveryCheckResponse {
	/**
	 * @var bool
	 */
	private $valid;

	/**
	 * @param bool $valid
	 */
	public function __construct($valid) {
		$this->valid = $valid;
	}

	/**
	 * @return boolean
	 */
	public function isValid() {
		return $this->valid;
	}

	public static function fromResponse($response) {
		return new UserRecoveryCheckResponse($response['valid']);
	}
}
