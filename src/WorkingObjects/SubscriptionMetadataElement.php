<?php

namespace Ixolit\Dislo\WorkingObjects;

/**
 * Class SubscriptionMetadataElement
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class SubscriptionMetadataElement implements WorkingObject
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var string
     */
    private $serviceIdentifier;

    /**
     * @var bool
     */
    private $unique;

    /**
     * @var bool
     */
    private $required;

    /**
     * @var int
     */
    private $fieldOrder;

    /**
     * SubscriptionMetadataElement constructor.
     *
     * @param string $name
     * @param string $displayName
     * @param string $serviceIdentifier
     * @param bool   $unique
     * @param bool   $required
     * @param int    $fieldOrder
     */
    public function __construct($name, $displayName, $serviceIdentifier, $unique, $required, $fieldOrder)
    {
        $this->name = $name;
        $this->displayName = $displayName;
        $this->serviceIdentifier = $serviceIdentifier;
        $this->unique = $unique;
        $this->required = $required;
        $this->fieldOrder = $fieldOrder;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getServiceIdentifier()
    {
        return $this->serviceIdentifier;
    }

    /**
     * @return bool
     */
    public function isUnique()
    {
        return $this->unique;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @return int
     */
    public function getFieldOrder()
    {
        return $this->fieldOrder;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionMetadataElement
     */
    public static function fromResponse($response)
    {
        return new self(
            $response['name'],
            $response['displayName'],
            $response['serviceIdentifier'],
            $response['unique'],
            $response['required'],
            $response['fieldOrder']
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            '_type'             => 'SubscriptionMetadataElement',
            'name'              => $this->getName(),
            'displayName'       => $this->getDisplayName(),
            'serviceIdentifier' => $this->getServiceIdentifier(),
            'unique'            => $this->isUnique(),
            'required'          => $this->isRequired(),
            'fieldOrder'        => $this->getFieldOrder(),
        ];
    }
}
