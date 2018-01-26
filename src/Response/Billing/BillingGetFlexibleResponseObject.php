<?php

namespace Ixolit\Dislo\Response\Billing;


use Ixolit\Dislo\WorkingObjects\Billing\FlexibleObject;


/**
 * Class BillingGetFlexibleResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingGetFlexibleResponseObject {

    /**
     * @var FlexibleObject
     */
    private $flexible;

    /**
     * @param FlexibleObject $flexible
     */
    public function __construct(FlexibleObject $flexible) {
        $this->flexible = $flexible;
    }

    /**
     * @return FlexibleObject
     */
    public function getFlexible() {
        return $this->flexible;
    }

    /**
     * @param array $response
     *
     * @return BillingGetFlexibleResponseObject
     */
    public static function fromResponse($response) {
        return new self(FlexibleObject::fromResponse($response['flexible']));
    }

}