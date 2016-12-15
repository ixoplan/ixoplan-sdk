<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\User;

class UserEmailVerificationFinishResponse {
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
	 * @return UserEmailVerificationFinishResponse
	 */
	public static function fromResponse($response) {
		return new UserEmailVerificationFinishResponse(User::fromResponse($response['user']));
	}
}