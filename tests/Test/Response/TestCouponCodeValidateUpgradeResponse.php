<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;
use Ixolit\Dislo\WorkingObjects\Coupon;
use Ixolit\Dislo\WorkingObjects\Price;

/**
 * Class TestCouponCodeValidateUpgradeResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestCouponCodeValidateUpgradeResponse implements TestResponseInterface {

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
     * @var Price
     */
    private $discountedPrice;

    /**
     * @var Price|null
     */
    private $recurringPrice;

    /**
     * TestCouponCodeValidateUpgradeResponse constructor.
     */
    public function __construct() {
        $this->couponCode = MockHelper::getFaker()->word;
        $this->event = Coupon::COUPON_EVENT_UPGRADE;
        $this->valid = MockHelper::getFaker()->boolean();
        $this->reason = MockHelper::getFaker()->word;
        $this->discountedPrice = PriceMock::create();
        $this->recurringPrice = PriceMock::create();
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
     * @return bool
     */
    public function isValid() {
        return $this->valid;
    }

    /**
     * @return string
     */
    public function getReason() {
        return $this->reason;
    }

    /**
     * @return Price
     */
    public function getDiscountedPrice() {
        return $this->discountedPrice;
    }

    /**
     * @return Price|null
     */
    public function getRecurringPrice() {
        return $this->recurringPrice;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        $response = [
            'valid' => $this->isValid(),
            'reason' => $this->getReason(),
        ];

        if ($this->getDiscountedPrice()) {
            $response['discountedPrice'] = $this->getDiscountedPrice()->toArray();
        }
        if ($this->getRecurringPrice()) {
            $response['recurringPrice'] = $this->getRecurringPrice()->toArray();
        }

        return $response;
    }
}