<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\User\MetaProfileElementObject;


/**
 * Class MetaProfileElementMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class MetaProfileElementMock {

    /**
     * @return MetaProfileElementObject
     */
    public static function create() {
        return new MetaProfileElementObject(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean()
        );
    }

}