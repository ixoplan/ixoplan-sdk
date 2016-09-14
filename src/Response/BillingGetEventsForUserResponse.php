<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\BillingEvent;

class BillingGetEventsForUserResponse {
	/**
	 * @var BillingEvent[]
	 */
	private $billingEvents;

	/**
	 * @param BillingEvent[] $billingEvents
	 */
	public function __construct(array $billingEvents) {
		$this->billingEvents = $billingEvents;
	}

	/**
	 * @return BillingEvent[]
	 */
	public function getBillingEvents() {
		return $this->billingEvents;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingGetEventsForUserResponse
	 */
	public static function fromResponse(array $response) {
		$billingEvents = [];
		foreach ($response['billingEvents'] as $billingEventArray) {
			$billingEvents[] = BillingEvent::fromResponse($billingEventArray);
		}

		return new BillingGetEventsForUserResponse($billingEvents);
	}
}