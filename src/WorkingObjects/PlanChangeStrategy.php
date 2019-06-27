<?php

namespace Ixolit\Dislo\WorkingObjects;


/**
 * Class PlanChangeStrategy
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class PlanChangeStrategy {

	private $identifier;

	private $name;

	private $description;

	private $isDefault = false;

	/**
	 * PlanChangeStrategy constructor.
	 * @param $identifier
	 * @param $name
	 * @param $description
	 * @param $isDefault
	 */
	public function __construct($identifier, $name, $description, $isDefault)
	{
		$this->identifier  = $identifier;
		$this->name        = $name;
		$this->description = $description;
		$this->isDefault   = $isDefault;
	}

	/**
	 * @return mixed
	 */
	public function getIdentifier()
	{
		return $this->identifier;
	}

	/**
	 * @param mixed $identifier
	 * @return $this
	 */
	public function setIdentifier($identifier)
	{
		$this->identifier = $identifier;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param mixed $description
	 * @return $this
	 */
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isDefault()
	{
		return $this->isDefault;
	}

	/**
	 * @param bool $isDefault
	 * @return $this
	 */
	public function setIsDefault($isDefault)
	{
		$this->isDefault = $isDefault;

		return $this;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return new self(
			$response['identifier'],
			$response['name'],
			$response['description'],
			$response['isDefault']
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
			'identifier' => $this->identifier,
			'name' => $this->name,
			'description' => $this->description,
			'isDefault' => $this->isDefault,
		];
	}

}