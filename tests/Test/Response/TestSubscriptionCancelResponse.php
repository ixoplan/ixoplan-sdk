<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;

/**
 * Class TestSubscriptionCancelResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionCancelResponse implements TestResponseInterface {

    /**
     * @var SubscriptionObject
     */
    private $subscription;

    /**
     * TestSubscriptionCancelResponse constructor.
     */
    public function __construct() {
        $this->subscription = SubscriptionMock::create(SubscriptionObject::STATUS_CANCELED);
    }

    /**
     * @return SubscriptionObject
     */
    public function getSubscription() {
        return $this->subscription;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'subscription' => $this->getSubscription()->toArray(),
        ];
    }
}