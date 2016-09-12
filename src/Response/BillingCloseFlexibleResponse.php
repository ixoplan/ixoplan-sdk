<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Flexible;

class BillingCloseFlexibleResponse {
	/**
	 * @var Flexible
	 */
	private $flexible;

	/**
	 * @param Flexible $flexible
	 */
	public function __construct($flexible) {
		$this->flexible = $flexible;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingCloseFlexibleResponse
	 */
	public static function fromResponse(array $response) {
		return new BillingCloseFlexibleResponse(Flexible::fromResponse($response['flexible']));
	}

	/**
	 * @return Flexible
	 */
	public function getFlexible() {
		return $this->flexible;
	}
}