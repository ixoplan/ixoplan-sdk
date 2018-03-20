<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Flexible;

/**
 * Class BillingGetFlexibleByIdentifierResponse
 *
 * @package Ixolit\Dislo\Response
 */
class BillingGetFlexibleByIdentifierResponse {

    /**
     * @var Flexible
     */
    private $flexible;

    /**
     * @param Flexible $flexible
     */
    public function __construct(Flexible $flexible) {
        $this->flexible = $flexible;
    }

    /**
     * @return Flexible
     */
    public function getFlexible() {
        return $this->flexible;
    }

    /**
     * @param array $response
     *
     * @return BillingGetFlexibleByIdentifierResponse
     */
    public static function fromResponse($response) {
        return new BillingGetFlexibleByIdentifierResponse(Flexible::fromResponse($response['flexible']));
    }

}