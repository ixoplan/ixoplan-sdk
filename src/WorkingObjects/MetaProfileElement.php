<?php

namespace Ixolit\Dislo\WorkingObjects;

class MetaProfileElement implements WorkingObject
{
	/**
	 * @var string
	 */
	private $name;

    /**
     * @var string|null
     */
	private $displayName;

    /**
     * @var string|null
     */
	private $metaprofileName;

	/**
	 * @var bool
	 */
	private $required;

	/**
	 * @var bool
	 */
	private $unique;

    /**
     * @param string      $name
     * @param bool        $required
     * @param bool        $unique
     * @param string||null   $displayName
     * @param string|null $metaprofileName
     */
	public function __construct($name, $required, $unique, $displayName = null, $metaprofileName = null)
    {
		$this->name     = $name;
		$this->required = $required;
		$this->unique   = $unique;
        $this->displayName = $displayName;
        $this->metaprofileName = $metaprofileName;
    }

	/**
	 * @return string
	 */
	public function getName()
    {
		return $this->name;
	}

    /**
     * @return string|null
     */
	public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @return string|null
     */
    public function getMetaprofileName()
    {
        return $this->metaprofileName;
    }

	/**
	 * @return boolean
	 */
	public function isRequired()
    {
		return $this->required;
	}

	/**
	 * @return boolean
	 */
	public function isUnique()
    {
		return $this->unique;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response)
    {
		return new MetaProfileElement(
			$response['name'],
			(bool)$response['required'],
			(bool)$response['unique'],
            isset($response['displayName']) ? $response['displayName'] : null,
            isset($response['metaprofileName']) ? $response['metaprofileName'] : null
		);
	}

	/**
	 * @return array
	 */
	public function toArray()
    {
		return [
            '_type'           => 'MetaProfileElement',
            'name'            => $this->getName(),
            'required'        => $this->isRequired(),
            'unique'          => $this->isUnique(),
            'displayName'     => $this->getDisplayName(),
            'metaprofileName' => $this->getMetaprofileName(),
		];
	}
}