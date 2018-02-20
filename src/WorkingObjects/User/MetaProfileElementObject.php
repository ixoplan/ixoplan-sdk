<?php

namespace Ixolit\Dislo\WorkingObjects\User;


use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;

/**
 * Class MetaProfileElementObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class MetaProfileElementObject extends AbstractWorkingObject {

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
     * @return MetaProfileElementObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValue($response, 'name'),
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
            'name'     => $this->name,
            'required' => $this->required,
            'unique'   => $this->unique,
        ];
    }

}