<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Subscription\DisplayNameObject;

/**
 * Class DisplayNameMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class DisplayNameMock {

    /**
     * @return DisplayNameObject
     */
    public static function create() {
        return new DisplayNameObject(
            MockHelper::getFaker()->languageCode,
            MockHelper::getFaker()->uuid
        );
    }

}