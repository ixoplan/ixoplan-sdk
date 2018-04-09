<?php

use Ixolit\Dislo\Response\BillingMethodsGetResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingMethodMock;
use Ixolit\Dislo\WorkingObjects\BillingMethod;

/**
 * Class BillingMethodsGetResponse
 */
class BillingMethodsGetResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $billingMethod = BillingMethodMock::create();
        $billingMethods = [
            $billingMethod->getBillingMethodId() => $billingMethod,
        ];

        $billingMethodsGetResponse = new BillingMethodsGetResponse($billingMethods);

        $reflectionObject = new \ReflectionObject($billingMethodsGetResponse);

        $billingMethodsProperty = $reflectionObject->getProperty('billingMethods');
        $billingMethodsProperty->setAccessible(true);

        /** @var BillingMethod[] $testBillingMethods */
        $testBillingMethods = $billingMethodsProperty->getValue($billingMethodsGetResponse);
        foreach ($testBillingMethods as $testBillingMethod) {
            if (empty($billingMethods[$testBillingMethod->getBillingMethodId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($testBillingMethod, $billingMethods[$testBillingMethod->getBillingMethodId()]);
        }
    }

    /**
     * @return void
     */
    public function testGetters() {
        $billingMethod = BillingMethodMock::create();
        $billingMethods = [
            $billingMethod->getBillingMethodId() => $billingMethod,
        ];

        $billingMethodsGetResponse = new BillingMethodsGetResponse($billingMethods);

        $testBillingMethods = $billingMethodsGetResponse->getBillingMethods();
        foreach ($testBillingMethods as $testBillingMethod) {
            if (empty($billingMethods[$testBillingMethod->getBillingMethodId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($testBillingMethod, $billingMethods[$testBillingMethod->getBillingMethodId()]);
        }
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $billingMethod = BillingMethodMock::create();
        $billingMethods = [
            $billingMethod->getBillingMethodId() => $billingMethod,
        ];

        $response = [
            'billingMethods' => \array_map(
                function($billingMethod) {
                    /** @var BillingMethod $billingMethod */
                    return $billingMethod->toArray();
                },
                $billingMethods
            )
        ];

        $billingMethodsGetResponse = BillingMethodsGetResponse::fromResponse($response);

        $testBillingMethods = $billingMethodsGetResponse->getBillingMethods();
        foreach ($testBillingMethods as $testBillingMethod) {
            if (empty($billingMethods[$testBillingMethod->getBillingMethodId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($testBillingMethod, $billingMethods[$testBillingMethod->getBillingMethodId()]);
        }
    }

}