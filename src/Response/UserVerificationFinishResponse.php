<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\User;

class UserVerificationFinishResponse {
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @param User $user
	 */
	public function __construct(User $user) {
		$this->user = $user;
	}

	/**
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param array $response
	 *
	 * @return UserVerificationFinishResponse
	 */
	public function fromResponse($response) {
		return new UserVerificationFinishResponse(User::fromResponse($response['user']));
	}
}