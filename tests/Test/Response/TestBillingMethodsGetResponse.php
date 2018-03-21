<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Client;
use Ixolit\Dislo\Test\WorkingObjects\BillingMethodMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\BillingMethod;


/**
 * Class TestBillingMethodsGetResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingMethodsGetResponse implements TestResponseInterface {

    /**
     * @var BillingMethod[]
     */
    private $billingMethodsWithoutRequirement;

    /**
     * @var BillingMethod[]
     */
    private $billingMethodsWithRequirement;

    /**
     * TestBillingMethodsGetResponse constructor.
     */
    public function __construct() {
        $objectsCount = MockHelper::getFaker()->numberBetween(1, 5);

        for ($i = 0; $i < $objectsCount; $i++) {
            $billingMethod = BillingMethodMock::create();
            $this->billingMethodsWithoutRequirement[$billingMethod->getName()] = $billingMethod;

            $billingMethodWithRequirement = BillingMethodMock::create();
            $this->billingMethodsWithRequirement[$billingMethodWithRequirement->getName()] = $billingMethodWithRequirement;
        }
    }

    /**
     * @return BillingMethod[]
     */
    public function getBillingMethodsWithoutRequirement() {
        return $this->billingMethodsWithoutRequirement;
    }

    /**
     * @return BillingMethod[]
     */
    public function getBillingMethodsWithRequirement() {
        return $this->billingMethodsWithRequirement;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        switch ($uri) {
            case Client::API_URI_BILLING_METHODS_GET_FOR_PACKAGE:
                $billingMethods = $this->getBillingMethodsWithRequirement();

                break;
            case Client::API_URI_BILLING_METHODS_GET:
                $billingMethods = $this->getBillingMethodsWithoutRequirement();

                break;
            default:
                return [];
        }

        $response = [
            'billingMethods' => [],
        ];

        foreach ($billingMethods as $billingMethod) {
            $response['billingMethods'][] = $billingMethod->toArray();
        }

        return $response;
    }

}