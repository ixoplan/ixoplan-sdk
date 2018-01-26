<?php

namespace Ixolit\Dislo\WorkingObjects\Subscription;


use Ixolit\Dislo\WorkingObjects\WorkingObject;

/**
 * Class CouponUsageObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class CouponUsageObject implements WorkingObject {

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
            isset($response['coupon'])
                ? CouponObject::fromResponse($response['coupon'])
                : null,
            $response['numPeriods'],
            isset($response['createdAt'])
                ? new \DateTime($response['createdAt'])
                : null,
            isset($response['modifiedAt'])
                ? new \DateTime($response['modifiedAt'])
                : null
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