<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\MetaProfileElementObject;

/**
 * Class UserGetMetaProfileResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserGetMetaProfileResponseObject {

    /**
     * @var MetaProfileElementObject[]
     */
    private $elements;

    /**
     * @param MetaProfileElementObject[] $elements
     */
    public function __construct(array $elements) {
        $this->elements = $elements;
    }

    /**
     * @return MetaProfileElementObject[]
     */
    public function getElements() {
        return $this->elements;
    }

    /**
     * @param array $response
     *
     * @return UserGetMetaProfileResponseObject
     */
    public static function fromResponse($response) {
        $elements = [];
        foreach ($response['metaProfile'] as $elementDescriptor) {
            $elements[] = MetaProfileElementObject::fromResponse($elementDescriptor);
        }
        return new self($elements);
    }

}