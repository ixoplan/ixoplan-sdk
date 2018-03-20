<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\MetaProfileElement;

/**
 * Class UserGetMetaProfileResponse
 *
 * @package Ixolit\Dislo\Response
 */
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

    /**
     * @param array $response
     *
     * @return UserGetMetaProfileResponse
     */
	public static function fromResponse($response) {
		$elements = [];
		foreach ($response['metaProfile'] as $elementDescriptor) {
			$elements[] = MetaProfileElement::fromResponse($elementDescriptor);
		}
		return new UserGetMetaProfileResponse($elements);
	}
}