<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserChangeResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserChangeResponse {

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
     * @return UserChangeResponse
     */
	public static function fromResponse($response) {
		return new UserChangeResponse(User::fromResponse($response['user']));
	}
}