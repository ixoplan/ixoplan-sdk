<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class TestSubscriptionAttachCouponResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionAttachCouponResponse implements TestResponseInterface {

    /**
     * @var bool
     */
    private $attached;

    /**
     * @var string|null
     */
    private $reason;

    /**
     * TestSubscriptionAttachCouponResponse constructor.
     */
    public function __construct() {
        $this->attached = MockHelper::getFaker()->boolean();
        $this->reason = MockHelper::getFaker()->word;
    }

    /**
     * @return bool|null
     */
    public function isAttached() {
        return $this->attached;
    }

    /**
     * @return null|string
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
        $response = [
            'attached' => $this->isAttached(),
        ];

        if (!empty($this->getReason())) {
            $response['reason'] = $this->getReason();
        }

        return $response;
    }
}