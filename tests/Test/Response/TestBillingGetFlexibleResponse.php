<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\Flexible;

/**
 * Class TestBillingGetFlexibleResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingGetFlexibleResponse implements TestResponseInterface {

    /**
     * @var Flexible|null
     */
    private $flexible;

    /**
     * TestBillingGetFlexibleResponse constructor.
     *
     * @param bool $noFlexible
     */
    public function __construct($noFlexible = false) {
        $this->flexible = $noFlexible
            ? null
            : FlexibleMock::create();
    }

    /**
     * @return Flexible|null
     */
    public function getFlexible() {
        return $this->flexible;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        if ($this->getFlexible()) {
            return [
                'flexible' => $this->getFlexible()->toArray(),
            ];
        }

        return [
            'success' => false,
            'errors'  => [
                [
                    'code'    => 404,
                    'message' => MockHelper::getFaker()->word,
                ],
            ],
        ];
    }

}