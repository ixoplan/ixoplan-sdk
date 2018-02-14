<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;
use Ixolit\Dislo\WorkingObjects\Subscription\PriceObject;

/**
 * Class TestSubscriptionCalculateAddonPriceResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionCalculateAddonPriceResponse implements TestResponseInterface {

    /**
     * @var bool
     */
    private $needsBilling;

    /**
     * @var PriceObject
     */
    private $price;

    /**
     * TestSubscriptionCalculateAddonPriceResponse constructor.
     */
    public function __construct() {
        $this->needsBilling = MockHelper::getFaker()->boolean();
        $this->price = PriceMock::create();
    }

    /**
     * @return bool
     */
    public function needsBilling() {
        return $this->needsBilling;
    }

    /**
     * @return PriceObject
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
            'price'        => $this->getPrice()->toArray(),
            'needsBilling' => $this->needsBilling(),
        ];
    }

}