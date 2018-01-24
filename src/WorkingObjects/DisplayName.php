<?php

namespace Ixolit\Dislo\WorkingObjects;


/**
 * Class DisplayName
 *
 * @package Ixolit\Dislo\WorkingObjects
 *
 * @deprecated use Ixolit\Dislo\WorkingObjects\DisplayNameObject instead
 */
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
	public static function fromResponse($response) {
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

	public function __toString() {
		return $this->getName();
	}
}