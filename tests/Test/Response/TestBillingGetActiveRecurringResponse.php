<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\RecurringMock;
use Ixolit\Dislo\WorkingObjects\Billing\RecurringObject;

/**
 * Class TestBillingGetActiveRecurringResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingGetActiveRecurringResponse implements TestResponseInterface {

    /**
     * @var RecurringObject
     */
    private $recurring;

    public function __construct() {
        $this->recurring = RecurringMock::create();
    }

    /**
     * @return RecurringObject
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