<?php

namespace Ixolit\Dislo\WorkingObjects\Subscription;


use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;
use Ixolit\Dislo\WorkingObjectsCustom\Subscription\CouponUsageObjectCustom;

/**
 * Class CouponUsageObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class CouponUsageObject extends AbstractWorkingObject {

    /**
     * @var CouponObject|null
     */
    private $coupon;

    /**
     * @var int
     */
    private $numPeriods;

    /**
     * @var \DateTime|null
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     */
    private $modifiedAt;

    /**
     * CouponUsage constructor.
     *
     * @param CouponObject|null $coupon
     * @param int               $numPeriods
     * @param \DateTime|null    $createdAt
     * @param \DateTime|null    $modifiedAt
     */
    public function __construct($coupon, $numPeriods, $createdAt, $modifiedAt) {
        $this->coupon = $coupon;
        $this->numPeriods = $numPeriods;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->addCustomObject();
    }

    /**
     * @return CouponUsageObjectCustom|null
     */
    public function getCustom() {
        /** @var CouponUsageObjectCustom $custom */
        $custom = ($this->getCustomObject() instanceof CouponUsageObjectCustom) ? $this->getCustomObject() : null;
        return $custom;
    }

    /**
     * @return CouponObject|null
     */
    public function getCoupon() {
        return $this->coupon;
    }

    /**
     * @return int
     */
    public function getNumPeriods() {
        return $this->numPeriods;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getModifiedAt() {
        return $this->modifiedAt;
    }

    /**
     * @param array $response
     *
     * @return CouponUsageObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValueIsSet($response, 'coupon', null, function ($value) {
                return CouponObject::fromResponse($value);
            }),
            static::getValueIsSet($response, 'numPeriods'),
            static::getValueAsDateTime($response, 'createdAt'),
            static::getValueAsDateTime($response, 'modifiedAt')
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'coupon'     => $this->coupon
                ? $this->coupon->toArray()
                : null,
            'numPeriods' => $this->numPeriods,
            'createdAt'  => $this->createdAt
                ? $this->createdAt->format('Y-m-d H:i:s')
                : null,
            'modifiedAt' => $this->modifiedAt
                ? $this->modifiedAt->format('Y-m-d H:i:s')
                : null,
        ];
    }

}