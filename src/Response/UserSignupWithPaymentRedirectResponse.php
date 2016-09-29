<?php

namespace Ixolit\Dislo\Response;

class UserSignupWithPaymentRedirectResponse extends UserSignupWithPaymentResponse  {
	/**
	 * @var string
	 */
	private $signupIdentifier;

	/**
	 * @var string
	 */
	private $redirectUrl;

	/**
	 * @var array
	 */
	private $metaData;

	/**
	 * @param string $signupIdentifier
	 * @param string $redirectUrl
	 * @param array  $metaData
	 */
	public function __construct($signupIdentifier, $redirectUrl, array $metaData) {
		parent::__construct(self::STATUS_REDIRECT_REQUIRED);

		$this->signupIdentifier = $signupIdentifier;
		$this->redirectUrl      = $redirectUrl;
		$this->metaData         = $metaData;
	}


	/**
	 * @return string
	 */
	public function getSignupIdentifier() {
		return $this->signupIdentifier;
	}

	/**
	 * @return string
	 */
	public function getRedirectUrl() {
		return $this->redirectUrl;
	}

	/**
	 * @return array
	 */
	public function getMetaData() {
		return $this->metaData;
	}

	public static function fromResponse($response) {
		return new UserSignupWithPaymentRedirectResponse(
			$response['signupIdentifier'],
			$response['redirectUrl'],
			$response['metaData']
		);
	}
}