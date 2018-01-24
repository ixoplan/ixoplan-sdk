<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\ExternalProfileObject;

/**
 * Class BillingExternalGetProfileResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingExternalGetProfileResponseObject {

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
     * @return BillingExternalGetProfileResponseObject
     */
    public static function fromResponse($response) {
        return new self(ExternalProfileObject::fromResponse($response['externalProfile']));
    }

}