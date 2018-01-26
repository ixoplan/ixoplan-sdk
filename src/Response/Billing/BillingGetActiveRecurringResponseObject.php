<?php

namespace Ixolit\Dislo\Response\Billing;


use Ixolit\Dislo\WorkingObjects\Billing\RecurringObject;


/**
 * Class BillingGetActiveRecurringResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingGetActiveRecurringResponseObject {

    /**
     * @var RecurringObject
     */
    private $recurring;

    /**
     * @param RecurringObject $recurring
     */
    public function __construct(RecurringObject $recurring) {
        $this->recurring = $recurring;
    }

    /**
     * @return RecurringObject
     */
    public function getRecurring() {
        return $this->recurring;
    }

    /**
     * @param array $response
     *
     * @return BillingGetActiveRecurringResponseObject
     */
    public static function fromResponse($response) {
        return new self(RecurringObject::fromResponse($response['recurring']));
    }

}