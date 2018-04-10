<?php

use Ixolit\Dislo\Response\UserGetMetaProfileResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MetaProfileElementMock;
use Ixolit\Dislo\WorkingObjects\MetaProfileElement;

/**
 * Class UserGetMetaProfileResponseTest
 */
class UserGetMetaProfileResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $element = MetaProfileElementMock::create();
        $elements = [
            $element->getName() => $element,
        ];

        $userGetMetaProfileResponse = new UserGetMetaProfileResponse($elements);

        $reflectionObject = new \ReflectionObject($userGetMetaProfileResponse);

        $elementsProperty = $reflectionObject->getProperty('elements');
        $elementsProperty->setAccessible(true);

        /** @var MetaProfileElement[] $testElements */
        $testElements = $elementsProperty->getValue($userGetMetaProfileResponse);
        foreach ($testElements as $testElement) {
            if (empty($elements[$testElement->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareMetaProfileElement($testElement, $elements[$testElement->getName()]);
        }
    }

    /**
     * @return void
     */
    public function testGetters() {
        $element = MetaProfileElementMock::create();
        $elements = [
            $element->getName() => $element,
        ];

        $userGetMetaProfileResponse = new UserGetMetaProfileResponse($elements);

        $testElements = $userGetMetaProfileResponse->getElements();
        foreach ($testElements as $testElement) {
            if (empty($elements[$testElement->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareMetaProfileElement($testElement, $elements[$testElement->getName()]);
        }
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $element = MetaProfileElementMock::create();
        $elements = [
            $element->getName() => $element,
        ];

        $response = [
            'metaProfile' => \array_map(
                function($element) {
                    /** @var MetaProfileElement $element */
                    return $element->toArray();
                },
                $elements
            )
        ];

        $userGetMetaProfileResponse = UserGetMetaProfileResponse::fromResponse($response);

        $testElements = $userGetMetaProfileResponse->getElements();
        foreach ($testElements as $testElement) {
            if (empty($elements[$testElement->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareMetaProfileElement($testElement, $elements[$testElement->getName()]);
        }
    }

}