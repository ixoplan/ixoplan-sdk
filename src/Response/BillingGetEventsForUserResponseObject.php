<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\BillingEventObject;

/**
 * Class BillingGetEventsForUserResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingGetEventsForUserResponseObject {

    /**
     * @var BillingEventObject[]
     */
    private $billingEvents;

    /**
     * @var int|null
     */
    private $totalCount;

    /**
     * @param BillingEventObject[] $billingEvents
     * @param int|null             $totalCount
     */
    public function __construct($billingEvents, $totalCount = null) {
        $this->billingEvents = $billingEvents;
        $this->totalCount = $totalCount;
    }

    /**
     * @return BillingEventObject[]
     */
    public function getBillingEvents() {
        return $this->billingEvents;
    }

    /**
     * @return int|null
     */
    public function getTotalCount() {
        return $this->totalCount;
    }

    /**
     * @param array $response
     *
     * @return BillingGetEventsForUserResponseObject
     */
    public static function fromResponse($response) {
        $billingEvents = [];
        foreach ($response['billingEvents'] as $billingEventArray) {
            $billingEvents[] = BillingEventObject::fromResponse($billingEventArray);
        }

        return new self(
            $billingEvents,
            isset($response['totalCount'])
                ? (int)$response['totalCount']
                : null
        );
    }

}