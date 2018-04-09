<?php

use Ixolit\Dislo\Response\BillingExternalGetProfileResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\ExternalProfileMock;

/**
 * Class BillingExternalGetProfileResponseTest
 */
class BillingExternalGetProfileResponseTest extends AbstractTestCase {

    /**
     * @retur void
     */
    public function testConstructor() {
        $externalProfile = ExternalProfileMock::create();

        $billingExternalGetProfileResponse = new BillingExternalGetProfileResponse($externalProfile);

        $reflectionObject = new \ReflectionObject($billingExternalGetProfileResponse);

        $externalProfileProperty = $reflectionObject->getProperty('externalProfile');
        $externalProfileProperty->setAccessible(true);
        $this->compareExternalProfile($externalProfileProperty->getValue($billingExternalGetProfileResponse), $externalProfile);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $externalProfile = ExternalProfileMock::create();

        $billingExternalGetProfileResponse = new BillingExternalGetProfileResponse($externalProfile);

        $this->compareExternalProfile($billingExternalGetProfileResponse->getExternalProfile(), $externalProfile);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $externalProfile = ExternalProfileMock::create();

        $response = [
            'externalProfile' => $externalProfile->toArray(),
        ];

        $billingExternalGetProfileResponse = BillingExternalGetProfileResponse::fromResponse($response);

        $this->compareExternalProfile($billingExternalGetProfileResponse->getExternalProfile(), $externalProfile);
    }

}