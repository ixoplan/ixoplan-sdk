<?php

namespace Ixolit\Dislo\Response\Billing;


use Ixolit\Dislo\WorkingObjects\ExternalProfileObject;

/**
 * Class BillingExternalGetProfileBySubscriptionIdResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingExternalGetProfileBySubscriptionIdResponseObject {

    /**
     * @var ExternalProfileObject
     */
    private $externalProfile;

    /**
     * @param ExternalProfileObject $externalProfile
     */
    public function __construct(ExternalProfileObject $externalProfile) {
        $this->externalProfile = $externalProfile;
    }

    /**
     * @return ExternalProfileObject
     */
    public function getExternalProfile() {
        return $this->externalProfile;
    }

    /**
     * @param array $response
     *
     * @return BillingExternalGetProfileBySubscriptionIdResponseObject
     */
    public static function fromResponse($response) {
        return new self(ExternalProfileObject::fromResponse($response['externalProfile']));
    }

}