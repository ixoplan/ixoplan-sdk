<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MetaProfileElementMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\MetaProfileElement;

/**
 * Class TestUserGetMetaProfileResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserGetMetaProfileResponse implements TestResponseInterface {

    /**
     * @var MetaProfileElement[]
     */
    private $elements;

    /**
     * TestUserGetMetaProfileResponse constructor.
     */
    public function __construct() {
        $elementsCount = MockHelper::getFaker()->numberBetween(1, 5);

        for ($i = 0; $i < $elementsCount; $i++) {
            $element = MetaProfileElementMock::create();

            $this->elements[$element->getName()] = $element;
        }
    }

    /**
     * @return MetaProfileElement[]
     */
    public function getElements() {
        return $this->elements;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        $elements = [];
        foreach ($this->getElements() as $element) {
            $elements[] = $element->toArray();
        }

        return [
            'metaProfile' => $elements,
        ];
    }
}