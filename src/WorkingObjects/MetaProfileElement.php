<?php

namespace Ixolit\Dislo\WorkingObjects;

class MetaProfileElement implements WorkingObject {
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var bool
	 */
	private $required;
	/**
	 * @var bool
	 */
	private $unique;

	/**
	 * @param string $name
	 * @param bool   $required
	 * @param bool   $unique
	 */
	public function __construct($name, $required, $unique) {
		$this->name     = $name;
		$this->required = $required;
		$this->unique   = $unique;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return boolean
	 */
	public function isRequired() {
		return $this->required;
	}

	/**
	 * @return boolean
	 */
	public function isUnique() {
		return $this->unique;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return new MetaProfileElement(
			$response['name'],
			(bool)$response['required'],
			(bool)$response['unique']
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
			'_type' => 'MetaProfileElement',
			'name' => $this->getName(),
			'required' => $this->isRequired(),
			'unique' => $this->isUnique()
		];
	}
}