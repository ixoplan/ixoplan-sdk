<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\BillingEvent;
use Ixolit\Dislo\WorkingObjects\Flexible;

class BillingCreateFlexibleResponse {
	/**
	 * @var Flexible
	 */
	private $flexible;

	/** @var string */
	private $redirectUrl;

    /**
     * @var BillingEvent|null
     */
    private $registerBillingEvent;

    /**
	 * @param Flexible      $flexible
	 * @param string|null   $redirectUrl
	 */
	public function __construct($flexible, $redirectUrl = null, $registerBillingEvent = null) {
		$this->flexible = $flexible;
		$this->redirectUrl = $redirectUrl;
        $this->registerBillingEvent = $registerBillingEvent;
    }

	/**
	 * @return Flexible
	 */
	public function getFlexible() {
		return $this->flexible;
	}

	/**
	 * @return null|string
	 */
	public function getRedirectUrl() {
		return $this->redirectUrl;
	}

    /**
     * @return BillingEvent|null
     */
	public function getRegisterBillingEvent()
    {
        return $this->registerBillingEvent;
    }

	/**
	 * @param array $response
	 *
	 * @return BillingCreateFlexibleResponse
	 */
	public static function fromResponse($response) {
		return new BillingCreateFlexibleResponse(
			Flexible::fromResponse($response['flexible']),
			isset($response['redirectUrl']) ? $response['redirectUrl'] : null,
            isset($response['registerEvent']) ? BillingEvent::fromResponse($response['registerEvent']) : null
		);
	}
}