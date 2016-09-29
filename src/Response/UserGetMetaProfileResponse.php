<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\MetaProfileElement;

class UserGetMetaProfileResponse {
	/**
	 * @var MetaProfileElement[]
	 */
	private $elements;

	/**
	 * @param \Ixolit\Dislo\WorkingObjects\MetaProfileElement[] $elements
	 */
	public function __construct(array $elements) {
		$this->elements = $elements;
	}

	/**
	 * @return \Ixolit\Dislo\WorkingObjects\MetaProfileElement[]
	 */
	public function getElements() {
		return $this->elements;
	}

	public static function fromResponse($response) {
		$elements = [];
		foreach ($response['metaProfile'] as $elementDescriptor) {
			$elements[] = MetaProfileElement::fromResponse($elementDescriptor);
		}
		return new UserGetMetaProfileResponse($elements);
	}
}