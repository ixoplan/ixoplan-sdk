<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\Client;

/**
 * Class CouponCodeResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated
 */
abstract class CouponCodeResponse {
	/**
	 * Coupon code does not exist.
	 */
	const REASON_INVALID_CODE = 'INVALID_CODE';

	/**
	 * Coupon is not valid at the current time.
	 */
	const REASON_NOT_VALID_NOW = 'INVALID_TIME';

	/**
	 * Coupon code is not enabled.
	 */
	const REASON_INVALID_MISC = 'INVALID_MISC';

	/**
	 * Coupon max usages reached.
	 */
	const REASON_MAX_USAGE_REACHED = 'INVALID_USAGE';
	/**
	 * Coupon is not applicable for the given event
	 */
	const REASON_INVALID_EVENT = 'INVALID_EVENT';

	private $couponCode;
	private $event;
	private $valid;
	private $reason;

	/**
	 * @param bool   $valid
	 * @param string $reason
	 * @param string $couponCode
	 * @param string $event
	 */
	public function __construct($valid, $reason, $couponCode, $event = '') {
		$this->valid  = $valid;
		$this->reason = $reason;
		$this->couponCode = $couponCode;
		$this->event = $event;
	}

	/**
	 * @return boolean
	 */
	public function isValid() {
		return $this->valid;
	}

	/**
	 * @see self::REASON_*
	 *
	 * @return string
	 */
	public function getReason() {
		return $this->reason;
	}

	public function getReasonAsText() {
		switch ($this->reason) {
			case self::REASON_INVALID_EVENT:
				if ($this->event == Client::COUPON_EVENT_START) {
					return 'This coupon code is not valid for new subscriptions.';
				} else if ($this->event == Client::COUPON_EVENT_UPGRADE) {
					return 'This coupon code is not valid for upgrades.';
				} else {
					return 'This coupon code is not valid.';
				}
			case self::REASON_MAX_USAGE_REACHED:
				return 'This coupon code has reached its usage limit.';
			case self::REASON_NOT_VALID_NOW:
				return 'This coupon code is not yet active or has expired.';
			default:
				return 'This coupon code is not valid.';
		}
	}

    /**
     * @return string
     */
	public function getCouponCode() {
	    return $this->couponCode;
    }

	/**
	 * @return string
	 */
	public function getEvent() {
		return $this->event;
	}

	public static function fromResponse($response, $couponCode, $event) {
		return new CouponCodeCheckResponse(
			$response['valid'],
			$response['reason'],
			$couponCode,
			$event
		);
	}
}