<?php

use Ixolit\Dislo\Response\BillingMethodsGetAvailableResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingMethodMock;
use Ixolit\Dislo\WorkingObjects\BillingMethod;

/**
 * Class BillingMethodsGetAvailableResponseTest
 */
class BillingMethodsGetAvailableResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $billingMethod = BillingMethodMock::create();
        $billingMethods = [
            $billingMethod->getBillingMethodId() => $billingMethod,
        ];

        $billingMethodsGetAvailableResponse = new BillingMethodsGetAvailableResponse($billingMethods);

        $reflectionObject = new \ReflectionObject($billingMethodsGetAvailableResponse);

        $reflectionObject = $reflectionObject->getParentClass();

        $billingMethodsProperty = $reflectionObject->getProperty('billingMethods');
        $billingMethodsProperty->setAccessible(true);

        /** @var BillingMethod[] $testBillingMethods */
        $testBillingMethods = $billingMethodsProperty->getValue($billingMethodsGetAvailableResponse);
        foreach ($testBillingMethods as $testBillingMethod) {
            if (empty($billingMethods[$testBillingMethod->getBillingMethodId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($testBillingMethod, $billingMethods[$testBillingMethod->getBillingMethodId()]);
        }
    }

}