<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Flexible;

/**
 * Class BillingGetFlexibleResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\BillingGetFlexibleResponseObject instead
 */
class BillingGetFlexibleResponse {
	/**
	 * @var Flexible
	 */
	private $flexible;

	/**
	 * @param Flexible $flexible
	 */
	public function __construct(Flexible $flexible) {
		$this->flexible = $flexible;
	}

	/**
	 * @return Flexible
	 */
	public function getFlexible() {
		return $this->flexible;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingGetFlexibleResponse
	 */
	public static function fromResponse($response) {
		return new BillingGetFlexibleResponse(Flexible::fromResponse($response['flexible']));
	}
}