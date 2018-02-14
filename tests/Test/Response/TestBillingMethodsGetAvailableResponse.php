<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\BillingMethodMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\Billing\BillingMethodObject;


/**
 * Class TestBillingMehtodsGetAvailableResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingMethodsGetAvailableResponse implements TestResponseInterface {

    /**
     * @var BillingMethodObject[]
     */
    private $billingMethods;

    /**
     * TestBillingMethodsGetResponse constructor.
     */
    public function __construct() {
        $objectsCount = MockHelper::getFaker()->numberBetween(1, 5);

        for ($i = 0; $i < $objectsCount; $i++) {
            $billingMethod = BillingMethodMock::create(true);
            $this->billingMethods[$billingMethod->getName()] = $billingMethod;
        }
    }

    /**
     * @return BillingMethodObject[]
     */
    public function getBillingMethods() {
        return $this->billingMethods;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        $response = [
            'billingMethods' => [],
        ];

        foreach ($this->getBillingMethods() as $billingMethod) {
            $response['billingMethods'][] = $billingMethod->toArray();
        }

        return $response;
    }

}