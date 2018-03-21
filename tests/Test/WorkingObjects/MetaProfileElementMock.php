<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\MetaProfileElement;

/**
 * Class MetaProfileElementMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class MetaProfileElementMock {

    /**
     * @return MetaProfileElement
     */
    public static function create() {
        return new MetaProfileElement(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean()
        );
    }

}