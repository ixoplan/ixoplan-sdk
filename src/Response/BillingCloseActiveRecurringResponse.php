<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Recurring;

/**
 * Class BillingCloseActiveRecurringResponse
 *
 * @package Ixolit\Dislo\Response
 */
class BillingCloseActiveRecurringResponse {

	/**
	 * @var Recurring
	 */
	private $recurring;

	/**
	 * @param Recurring $recurring
	 */
	public function __construct(Recurring $recurring) {
		$this->recurring = $recurring;
	}

	/**
	 * @return Recurring
	 */
	public function getRecurring() {
		return $this->recurring;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingCloseActiveRecurringResponse
	 */
	public static function fromResponse($response) {
		return new BillingCloseActiveRecurringResponse(Recurring::fromResponse($response['recurring']));
	}
}