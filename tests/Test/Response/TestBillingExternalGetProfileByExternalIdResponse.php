<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\ExternalProfileMock;
use Ixolit\Dislo\WorkingObjects\ExternalProfile;

/**
 * Class TestBillingExternalGetProfileByExternalIdResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingExternalGetProfileByExternalIdResponse implements TestResponseInterface {

    /**
     * @var ExternalProfile
     */
    private $externalProfile;

    /**
     * TestBillingExternalGetProfileByExternalIdResponse constructor.
     */
    public function __construct() {
        $this->externalProfile = ExternalProfileMock::create();
    }

    /**
     * @return ExternalProfile
     */
    public function getExternalProfile() {
        return $this->externalProfile;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'externalProfile' => $this->getExternalProfile()->toArray(),
        ];
    }

}