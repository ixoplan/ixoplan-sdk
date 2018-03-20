<?php

namespace Ixolit\Dislo\WorkingObjects;


use Ixolit\Dislo\WorkingObjectsCustom\User\MetaProfileElementCustom;


/**
 * Class MetaProfileElement
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class MetaProfileElement extends AbstractWorkingObject {

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

		$this->addCustomObject();
	}

    /**
     * @return MetaProfileElementCustom|null
     */
    public function getCustom() {
        /** @var MetaProfileElementCustom $custom */
        $custom = ($this->getCustomObject() instanceof MetaProfileElementCustom)
            ? $this->getCustomObject()
            : null;

        return $custom;
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
        return new self(
            static::getValueIsSet($response, 'name'),
            static::getValueAsBool($response, 'required'),
            static::getValueAsBool($response, 'unique')
        );
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
            '_type'    => 'MetaProfileElement',
            'name'     => $this->getName(),
            'required' => $this->isRequired(),
            'unique'   => $this->isUnique(),
        ];
	}
}