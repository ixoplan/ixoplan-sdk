<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class TestSubscriptionCreateAddon
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionCreateAddonResponse implements TestResponseInterface {

    /**
     * @var Subscription
     */
    private $subscription;

    /**
     * @var bool
     */
    private $needsBilling;

    /**
     * @var Price
     */
    private $price;

    /**
     * TestSubscriptionCreateAddonResponse constructor.
     */
    public function __construct() {
        $this->subscription = SubscriptionMock::create();
        $this->needsBilling = MockHelper::getFaker()->boolean();
        $this->price = PriceMock::create();
    }

    /**
     * @return Subscription
     */
    public function getSubscription() {
        return $this->subscription;
    }

    /**
     * @return bool
     */
    public function needsBilling() {
        return $this->needsBilling;
    }

    /**
     * @return Price
     */
    public function getPrice() {
        return $this->price;
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
            'needsBilling' => $this->needsBilling(),
            'price'        => $this->getPrice()->toArray(),
        ];
    }
}