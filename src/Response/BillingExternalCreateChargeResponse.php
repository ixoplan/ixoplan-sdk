<?php

namespace Ixolit\Dislo\Response;

class BillingExternalCreateChargeResponse {
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
	 * @return BillingExternalCreateChargeResponse
	 */
	public static function fromResponse($response) {
		return new BillingExternalCreateChargeResponse($response['billingEventId']);
	}
}