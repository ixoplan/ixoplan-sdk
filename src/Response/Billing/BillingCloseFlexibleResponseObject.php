<?php

namespace Ixolit\Dislo\Response\Billing;


use Ixolit\Dislo\WorkingObjects\FlexibleObject;

/**
 * Class BillingCloseFlexibleResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingCloseFlexibleResponseObject {

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
     * @return BillingCloseFlexibleResponseObject
     */
    public static function fromResponse($response) {
        return new BillingCloseFlexibleResponseObject(FlexibleObject::fromResponse($response['flexible']));
    }

}