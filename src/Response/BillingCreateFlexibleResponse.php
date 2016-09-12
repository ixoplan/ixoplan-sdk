<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Flexible;

class BillingCreateFlexible {
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
	 * @return BillingCreateFlexible
	 */
	public function fromResponse(array $response) {
		return new BillingCreateFlexible(Flexible::fromResponse($response['flexible']));
	}
}