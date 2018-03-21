<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\Flexible;

/**
 * Class TestBillingCreateFlexibleResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingCreateFlexibleResponse implements TestResponseInterface {

    /**
     * @var Flexible
     */
    private $flexible;

    /**
     * @var string|null
     */
    private $redirectUrl;

    /**
     * TestBillingCreateFlexibleResponse constructor.
     */
    public function __construct() {
        $this->flexible = FlexibleMock::create();
        $this->redirectUrl = MockHelper::getFaker()->url;
    }

    /**
     * @return Flexible
     */
    public function getFlexible() {
        return $this->flexible;
    }

    /**
     * @return null|string
     */
    public function getRedirectUrl() {
        return $this->redirectUrl;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'flexible' => $this->getFlexible()->toArray(),
            'redirectUrl' => $this->getRedirectUrl(),
        ];
    }

}