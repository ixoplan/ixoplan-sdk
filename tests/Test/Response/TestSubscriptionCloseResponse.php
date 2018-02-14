<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;

/**
 * Class TestSubscriptionCloseResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionCloseResponse implements TestResponseInterface {

    /**
     * @var SubscriptionObject
     */
    private $subscription;

    /**
     * TestSubscriptionCloseResponse constructor.
     */
    public function __construct() {
        $this->subscription = SubscriptionMock::create();
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