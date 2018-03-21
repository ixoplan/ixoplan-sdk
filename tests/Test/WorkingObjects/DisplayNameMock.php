<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\DisplayName;

/**
 * Class DisplayNameMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class DisplayNameMock {

    /**
     * @return DisplayName
     */
    public static function create() {
        return new DisplayName(
            MockHelper::getFaker()->languageCode,
            MockHelper::getFaker()->uuid
        );
    }

}