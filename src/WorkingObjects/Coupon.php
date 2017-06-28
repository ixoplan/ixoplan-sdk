<?php

namespace Ixolit\Dislo\WorkingObjects;

class Coupon implements WorkingObject {

	/** @var string */
	private $code;

	/** @var string */
	private $description;

	/**
	 * Coupon constructor.
	 *
	 * @param string $code
	 * @param string $description
	 */
	public function __construct($code, $description) {
		$this->code = $code;
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return new Coupon(
			$response['code'],
			$response['description']
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
			'code' => $this->code,
			'description' => $this->description,
		];
	}
}