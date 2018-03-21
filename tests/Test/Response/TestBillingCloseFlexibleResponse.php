<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;
use Ixolit\Dislo\WorkingObjects\Flexible;

/**
 * Class TestBillingCloseFlexibleResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingCloseFlexibleResponse implements TestResponseInterface {

    /**
     * @var Flexible
     */
    private $flexible;

    /**
     * TestBillingCloseFlexibleResponse constructor.
     */
    public function __construct() {
        $this->flexible = FlexibleMock::create(Flexible::STATUS_CLOSED);
    }

    /**
     * @return Flexible
     */
    public function getFlexible() {
        return $this->flexible;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'flexible' => $this->getFlexible()->toArray(),
        ];
    }

}