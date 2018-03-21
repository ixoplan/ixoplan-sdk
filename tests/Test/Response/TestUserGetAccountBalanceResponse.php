<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\PriceMock;
use Ixolit\Dislo\WorkingObjects\Price;

/**
 * Class TestUserGetAccountBalanceResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserGetAccountBalanceResponse implements TestResponseInterface {

    /**
     * @var Price
     */
    private $balance;

    /**
     * TestUserGetAccountBalanceResponse constructor.
     */
    public function __construct() {
        $this->balance = PriceMock::create();
    }

    /**
     * @return Price
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        if ($this->getBalance()) {
            return [
                'balance' => $this->getBalance()->toArray(),
            ];
        }

        return [];
    }
}