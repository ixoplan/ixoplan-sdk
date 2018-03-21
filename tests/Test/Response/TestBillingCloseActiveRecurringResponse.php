<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\RecurringMock;
use Ixolit\Dislo\WorkingObjects\Recurring;

/**
 * Class TestBillingCloseActiveRecurringResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingCloseActiveRecurringResponse implements TestResponseInterface {

    /**
     * @var Recurring
     */
    private $recurring;

    public function __construct() {
        $this->recurring = RecurringMock::create();
    }

    /**
     * @return Recurring
     */
    public function getRecurring() {
        return $this->recurring;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'recurring' => $this->getRecurring()->toArray(),
        ];
    }

}