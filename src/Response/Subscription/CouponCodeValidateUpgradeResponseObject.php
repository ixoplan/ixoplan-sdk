<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\FrontendClient;
use Ixolit\Dislo\WorkingObjects\PriceObject;


/**
 * Class CouponCodeValidateUpgradeResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class CouponCodeValidateUpgradeResponseObject {

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

    /**
     * @var string
     */
    private $couponCode;

    /**
     * @var string
     */
    private $event;

    /**
     * @var bool
     */
    private $valid;

    /**
     * @var string
     */
    private $reason;
    /**
     * @var PriceObject
     */
    private $discountedPrice;

    /** @var PriceObject|null */
    private $recurringPrice;

    /**
     * @param bool   	 $valid
     * @param string 	 $reason
     * @param string 	 $couponCode
     * @param string 	 $event
     * @param PriceObject 	 $discountedPrice
     * @param PriceObject|null $recurringPrice
     */
    public function __construct(
        $valid,
        $reason,
        $couponCode,
        $event,
        PriceObject $discountedPrice,
        PriceObject $recurringPrice = null
    ) {
        $this->valid           = $valid;
        $this->reason          = $reason;
        $this->couponCode      = $couponCode;
        $this->event           = $event;
        $this->discountedPrice = $discountedPrice;
        $this->recurringPrice  = $recurringPrice;
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

    /**
     * @return PriceObject
     */
    public function getDiscountedPrice() {
        return $this->discountedPrice;
    }

    /**
     * @return PriceObject|null
     */
    public function getRecurringPrice() {
        return $this->recurringPrice;
    }

    /**
     * @return string
     */
    public function getReasonAsText() {
        switch ($this->reason) {
            case self::REASON_INVALID_EVENT:
                if ($this->event == FrontendClient::COUPON_EVENT_START) {
                    return 'This coupon code is not valid for new subscriptions.';
                } else if ($this->event == FrontendClient::COUPON_EVENT_UPGRADE) {
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

    /**
     * @param array  $response
     * @param string $couponCode
     * @param string $event
     *
     * @return CouponCodeValidateUpgradeResponseObject
     */
    public static function fromResponse($response, $couponCode, $event) {
        return new self(
            $response['valid'],
            $response['reason'],
            $couponCode,
            $event,
            PriceObject::fromResponse($response['discountedPrice']),
            PriceObject::fromResponse($response['recurringPrice'])
        );
    }

}