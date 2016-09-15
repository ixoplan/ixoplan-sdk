<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\BillingEvent;

class BillingGetEventResponse {
	/**
	 * @var BillingEvent
	 */
	private $billingEvent;

	/**
	 * @param BillingEvent $billingEvent
	 */
	public function __construct(BillingEvent $billingEvent) {
		$this->billingEvent = $billingEvent;
	}

	/**
	 * @return BillingEvent
	 */
	public function getBillingEvent() {
		return $this->billingEvent;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingGetEventResponse
	 */
	public static function fromResponse($response) {
		return new BillingGetEventResponse(BillingEvent::fromResponse($response['billingEvent']));
	}
}