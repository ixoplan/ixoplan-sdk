<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\BillingEvent;

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
     * @var BillingEvent
     */
    private $billingEvent;

    /**
     * TestBillingCreatePaymentResponse constructor.
     *
     * @param bool $withRedirectUrl
     */
    public function __construct($withRedirectUrl = true) {
        $this->redirectUrl = $withRedirectUrl
            ? MockHelper::getFaker()->url
            : null;
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
     * @return BillingEvent
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
        $response = [
            'metaData'     => $this->getMetaData(),
            'billingEvent' => $this->getBillingEvent()->toArray(),
        ];

        if (!empty($this->redirectUrl)) {
            $response['redirectUrl']  = $this->getRedirectUrl();
        }

        return $response;
    }

}