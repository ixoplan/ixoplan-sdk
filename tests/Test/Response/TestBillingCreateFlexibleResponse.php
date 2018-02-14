<?php

namespace Ixolit\Dislo\Test\Response;


use Faker\Factory;
use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\Billing\FlexibleObject;

/**
 * Class TestBillingCreateFlexibleResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingCreateFlexibleResponse implements TestResponseInterface {

    /**
     * @var FlexibleObject
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
     * @return FlexibleObject
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