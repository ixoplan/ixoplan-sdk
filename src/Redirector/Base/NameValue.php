<?php

namespace Ixolit\Dislo\Redirector\Base;

/**
 * Class NameValue
 * @package Ixolit\Dislo\Redirector\Base
 */
class NameValue {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
}