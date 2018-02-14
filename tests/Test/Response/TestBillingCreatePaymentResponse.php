<?php

namespace Ixolit\Dislo\Test\Response;


use Faker\Factory;
use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\Billing\BillingEventObject;

/**
 * Class TestBillingCreatePaymentResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingCreatePaymentResponse implements TestResponseInterface {

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @var array
     */
    private $metaData;

    /**
     * @var BillingEventObject
     */
    private $billingEvent;

    /**
     * TestBillingCreatePaymentResponse constructor.
     */
    public function __construct() {
        $this->redirectUrl = MockHelper::getFaker()->url;
        $this->metaData = [
            MockHelper::getFaker()->word => MockHelper::getFaker()->word,
        ];
        $this->billingEvent = BillingEventMock::create();
    }

    /**
     * @return string
     */
    public function getRedirectUrl() {
        return $this->redirectUrl;
    }

    /**
     * @return array
     */
    public function getMetaData() {
        return $this->metaData;
    }

    /**
     * @return BillingEventObject
     */
    public function getBillingEvent() {
        return $this->billingEvent;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'redirectUrl'  => $this->getRedirectUrl(),
            'metaData'     => $this->getMetaData(),
            'billingEvent' => $this->getBillingEvent()->toArray(),
        ];
    }

}