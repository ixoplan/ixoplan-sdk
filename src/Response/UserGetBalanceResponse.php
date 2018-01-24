<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;

/**
 * Class UserGetBalanceResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\UserGetBalanceResponseObject
 */
class UserGetBalanceResponse {
	/**
	 * @var Price
	 */
	private $balance;

	/**
	 * @param Price $balance
	 */
	public function __construct(Price $balance) {
		$this->balance = $balance;
	}

	/**
	 * @return Price
	 */
	public function getBalance() {
		return $this->balance;
	}

	public static function fromResponse($response) {
		return new UserGetBalanceResponse(Price::fromResponse($response['balance']));
	}
}