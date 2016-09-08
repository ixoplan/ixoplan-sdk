<?php

namespace Ixolit\Dislo\WorkingObjects;

class DisplayName implements WorkingObject {

	/**
	 * @var string
	 */
	private $language;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @param string $language
	 * @param string $name
	 */
	public function __construct($language, $name) {
		$this->language = $language;
		$this->name     = $name;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse(array $response) {
		return new DisplayName(
			$response['language'],
			$response['name']
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
			'_type'    => 'DisplayName',
			'language' => $this->getLanguage(),
			'name'     => $this->getName(),
		];
	}

	/**
	 * @return string
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
}