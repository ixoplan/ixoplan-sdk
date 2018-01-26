<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\ExternalProfile;

/**
 * Class BillingExternalGetProfileResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated
 */
class BillingExternalGetProfileResponse {
	/**
	 * @var ExternalProfile
	 */
	private $externalProfile;

	/**
	 * @param ExternalProfile $externalProfile
	 */
	public function __construct(ExternalProfile $externalProfile) {
		$this->externalProfile = $externalProfile;
	}

	/**
	 * @return ExternalProfile
	 */
	public function getExternalProfile() {
		return $this->externalProfile;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingExternalGetProfileResponse
	 */
	public static function fromResponse($response) {
		return new BillingExternalGetProfileResponse(ExternalProfile::fromResponse($response['externalProfile']));
	}
}