<?php

namespace Ixolit\Dislo\Test\Response;

use Faker\Factory;

/**
 * Class TestCouponCodeCheckResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestCouponCodeCheckResponse implements TestResponseInterface {

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
     * TestCouponCodeCheckResponse constructor.
     *
     * @param string $couponCode
     * @param string $event
     */
    public function __construct($couponCode, $event) {
        $faker = Factory::create();

        $this->couponCode = $couponCode;
        $this->event      = $event;
        $this->valid      = (bool)\rand(0, 1);
        $this->reason     = $faker->word;
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
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'couponCode' => $this->getCouponCode(),
            'valid'      => $this->isValid(),
            'event'      => $this->getEvent(),
            'reason'     => $this->getReason(),
        ];
    }

}