<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\BillingMethodObject;

/**
 * Class BillingMethodsGetAvailableResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingMethodsGetAvailableResponseObject {

    /**
     * @var BillingMethodObject[]
     */
    private $billingMethods;

    /**
     * @param BillingMethodObject[] $billingMethods
     */
    public function __construct($billingMethods) {
        $this->billingMethods = $billingMethods;
    }

    /**
     * @return BillingMethodObject[]
     */
    public function getBillingMethods() {
        return $this->billingMethods;
    }

}