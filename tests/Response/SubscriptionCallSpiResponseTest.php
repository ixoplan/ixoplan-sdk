<?php

use Ixolit\Dislo\Response\SubscriptionCallSpiResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class SubscriptionCallSpiResponseTest
 */
class SubscriptionCallSpiResponseTest extends AbstractTestCase {

    /**
     * @rerurn void
     */
    public function testConstructor() {
        $spiResponse = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];

        $subscriptionCallSpiResponse = new SubscriptionCallSpiResponse($spiResponse);

        $reflectionObject = new \ReflectionObject($subscriptionCallSpiResponse);

        $spiResponseProperty = $reflectionObject->getProperty('spiResponse');
        $spiResponseProperty->setAccessible(true);
        $this->assertEquals($spiResponse, $spiResponseProperty->getValue($subscriptionCallSpiResponse));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $spiResponse = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];

        $subscriptionCallSpiResponse = new SubscriptionCallSpiResponse($spiResponse);

        $this->assertEquals($spiResponse, $subscriptionCallSpiResponse->getSpiResponse());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $response = [
            'spiResponse' => [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ]
        ];

        $subscriptionCallSpiResponse = SubscriptionCallSpiResponse::fromResponse($response);

        $this->assertEquals($response['spiResponse'], $subscriptionCallSpiResponse->getSpiResponse());
    }

}