<?php

namespace Ixolit\Dislo\Response;

class BillingExternalCreateChargebackResponse {
	/**
	 * @var int
	 */
	private $billingEventId;

	/**
	 * @param int $billingEventId
	 */
	public function __construct($billingEventId) {
		$this->billingEventId = $billingEventId;
	}

	/**
	 * @return int
	 */
	public function getBillingEventId() {
		return $this->billingEventId;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingExternalCreateChargebackResponse
	 */
	public static function fromResponse(array $response) {
		return new BillingExternalCreateChargebackResponse($response['billingEventId']);
	}
}