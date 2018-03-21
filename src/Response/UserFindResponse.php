<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserFindResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserFindResponse {

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
     * @return UserFindResponse
     */
	public static function fromResponse($response) {
		return new UserFindResponse(User::fromResponse($response['user']));
	}

}