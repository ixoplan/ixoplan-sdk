<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserRecoveryCheckResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\UserRecoveryCheckResponseObject instead
 */
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
