<?php

namespace Ixolit\Dislo\WorkingObjects;

/**
 * Interface WorkingObjectCustomInterface
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
interface WorkingObjectCustomInterface {

    /**
     * @param WorkingObject $object
     *
     * @return $this
     */
    public function setWorkingObject(WorkingObject $object);
}