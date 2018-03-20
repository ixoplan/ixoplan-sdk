<?php

namespace Ixolit\Dislo\WorkingObjects;

/**
 * Class CachedObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class CachedObject {

    /**
     * @var mixed
     */
    private $object;

    /**
     * CachedObject constructor.
     *
     * @param mixed $object
     */
    public function __construct($object) {
        $this->object = $object;
    }

    /**
     * @return mixed
     */
    public function getObject() {
        return $this->object;
    }

}