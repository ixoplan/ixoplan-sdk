<?php

namespace Ixolit\Dislo\Response;


/**
 * Class SubscriptionAttachCouponResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionAttachCouponResponseObject {

    /**
     * @var bool|null
     */
    private $attached;

    /**
     * @var string|null
     */
    private $reason;

    /**
     * SubscriptionAttachCouponResponse constructor.
     *
     * @param bool   $attached
     * @param string $reason
     */
    public function __construct($attached, $reason) {
        $this->attached = $attached;
        $this->reason   = $reason;
    }

    /**
     * @return bool|null
     */
    public function getAttached() {
        return $this->attached;
    }

    /**
     * @return null|string
     */
    public function getReason() {
        return $this->reason;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionAttachCouponResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            isset($response['attached'])
                ? $response['attached']
                : null,
            isset($response['reason'])
                ? $response['reason']
                : null
        );
    }

}