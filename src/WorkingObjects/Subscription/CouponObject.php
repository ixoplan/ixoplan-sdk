<?php

namespace Ixolit\Dislo\WorkingObjects\Subscription;


use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;
use Ixolit\Dislo\WorkingObjectsCustom\Subscription\CouponObjectCustom;

/**
 * Class CouponObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class CouponObject extends AbstractWorkingObject {

    const COUPON_EVENT_START = 'subscription_start';
    const COUPON_EVENT_UPGRADE = 'subscription_upgrade';

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $description;

    /**
     * Coupon constructor.
     *
     * @param string $code
     * @param string $description
     */
    public function __construct($code, $description) {
        $this->code        = $code;
        $this->description = $description;
        $this->addCustomObject();
    }

    /**
     * @return CouponObjectCustom|null
     */
    public function getCustom() {
        /** @var CouponObjectCustom $custom */
        $custom = ($this->getCustomObject() instanceof CouponObjectCustom) ? $this->getCustomObject() : null;
        return $custom;
    }

    /**
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param array $response
     *
     * @return CouponObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValueIsSet($response, 'code'),
            static::getValueIsSet($response, 'description')
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'code'        => $this->code,
            'description' => $this->description,
        ];
    }

}