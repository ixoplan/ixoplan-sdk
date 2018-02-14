<?php

namespace Ixolit\Dislo\WorkingObjects\Subscription;


use Ixolit\Dislo\WorkingObjects\WorkingObject;

/**
 * Class CouponObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class CouponObject implements WorkingObject {

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
            $response['code'],
            $response['description']
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