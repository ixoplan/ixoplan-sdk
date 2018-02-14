<?php

namespace Ixolit\Dislo\Response\Subscription;


/**
 * Class SubscriptionAttachCouponResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionAttachCouponResponseObject {

    /**
     * @var bool
     */
    private $attached;

    /**
     * @var string|null
     */
    private $reason;

    /**
     * SubscriptionAttachCouponResponse constructor.
     *
     * @param bool        $attached
     * @param string|null $reason
     */
    public function __construct($attached, $reason) {
        $this->attached = $attached;
        $this->reason   = $reason;
    }

    /**
     * @return bool
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
            $response['attached'],
            isset($response['reason'])
                ? $response['reason']
                : null
        );
    }

}