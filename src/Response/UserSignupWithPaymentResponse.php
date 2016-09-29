<?php

namespace Ixolit\Dislo\Response;

abstract class UserSignupWithPaymentResponse {
	const STATUS_REDIRECT_REQUIRED = 'redirect_required';
	const STATUS_FINISHED = 'finished';

	/**
	 * @see self::STATUS_*
	 *
	 * @var string
	 */
	private $status;

	/**
	 * @param string $status
	 */
	public function __construct($status) {
		$this->status = $status;
	}

	/**
	 * Returns the status. Depending on the status, a subclass of this class contains the specific fields.
	 *
	 * @see self::STATUS_*
	 *
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	public static function fromResponse($response) {
		if (isset($response['user'])) {
			return UserSignupWithPaymentFinishedResponse::fromResponse($response);
		} else {
			return UserSignupWithPaymentRedirectResponse::fromResponse($response);
		}
	}
}