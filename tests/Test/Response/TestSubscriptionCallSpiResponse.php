<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MockHelper;


/**
 * Class TestsubscriptionCallSpiResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionCallSpiResponse implements TestResponseInterface {

    /**
     * @var array
     */
    private $spiResponse;

    /**
     * TestSubscriptionCallSpiResponse constructor.
     */
    public function __construct() {
        $this->spiResponse = [
            MockHelper::getFaker()->word => MockHelper::getFaker()->word,
        ];
    }

    /**
     * @return array
     */
    public function getSpiResponse() {
        return $this->spiResponse;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'spiResponse' => $this->getSpiResponse(),
        ];
    }
}