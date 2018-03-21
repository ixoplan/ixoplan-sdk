<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;
use Ixolit\Dislo\WorkingObjects\Price;

/**
 * Class TestSubscriptionCalculatePriceResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionCalculatePriceResponse implements TestResponseInterface {

    /**
     * @var Price
     */
    private $price;

    /**
     * @var bool
     */
    private $needsBilling;

    /**
     * @var bool
     */
    private $appliedImmediately;

    /**
     * @var Price|null
     */
    private $recurringPrice;

    /**
     * TestSubscriptionCalculatePackageChange constructor.
     */
    public function __construct() {
        $this->price              = PriceMock::create();
        $this->needsBilling       = MockHelper::getFaker()->boolean();
        $this->appliedImmediately = MockHelper::getFaker()->boolean();
        $this->recurringPrice     = PriceMock::create();
    }

    /**
     * @return Price
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @return bool
     */
    public function needsBilling() {
        return $this->needsBilling;
    }

    /**
     * @return bool
     */
    public function appliedImmediately() {
        return $this->appliedImmediately;
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
        return [
            'price'              => $this->getPrice()->toArray(),
            'needsBilling'       => $this->needsBilling(),
            'appliedImmediately' => $this->appliedImmediately(),
            'recurringPrice'     => $this->getRecurringPrice()
                ? $this->getRecurringPrice()->toArray()
                : null,
        ];
    }

}