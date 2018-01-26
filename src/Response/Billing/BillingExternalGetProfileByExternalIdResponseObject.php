<?php

namespace Ixolit\Dislo\Response\Billing;


use Ixolit\Dislo\WorkingObjects\Billing\ExternalProfileObject;


/**
 * Class BillingExternalGetProfileByExternalIdResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingExternalGetProfileByExternalIdResponseObject {

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
     * @return BillingExternalGetProfileByExternalIdResponseObject
     */
    public static function fromResponse($response) {
        return new self(ExternalProfileObject::fromResponse($response['externalProfile']));
    }

}