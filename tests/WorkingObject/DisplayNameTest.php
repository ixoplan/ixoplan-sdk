<?php

use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\DisplayName;
use Ixolit\Dislo\WorkingObjectsCustom\DisplayNameCustom;

/**
 * Class DisplayNameTest
 */
class DisplayNameTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $language = MockHelper::getFaker()->languageCode;
        $name     = MockHelper::getFaker()->word;

        $displayName = new DisplayName($language, $name);

        $reflectionObject = new \ReflectionObject($displayName);

        $languageProperty = $reflectionObject->getProperty('language');
        $languageProperty->setAccessible(true);
        $this->assertEquals($language, $languageProperty->getValue($displayName));

        $nameProperty = $reflectionObject->getProperty('name');
        $nameProperty->setAccessible(true);
        $this->assertEquals($name, $nameProperty->getValue($displayName));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $language = MockHelper::getFaker()->languageCode;
        $name     = MockHelper::getFaker()->word;

        $displayName = new DisplayName($language, $name);

        $this->assertEquals($language, $displayName->getLanguage());
        $this->assertEquals($name, $displayName->getName());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $response = [
            'language' => MockHelper::getFaker()->languageCode,
            'name'     => MockHelper::getFaker()->word
        ];

        $displayName = DisplayName::fromResponse($response);

        $this->assertEquals($response['language'], $displayName->getLanguage());
        $this->assertEquals($response['name'], $displayName->getName());
    }

    /**
     * @return void
     */
    public function testToArray() {
        $displayName = new DisplayName(MockHelper::getFaker()->languageCode, MockHelper::getFaker()->word);

        $displayNameArray = $displayName->toArray();

        $this->assertEquals($displayName->getLanguage(), $displayNameArray['language']);
        $this->assertEquals($displayName->getName(), $displayNameArray['name']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $displayName = new DisplayName(MockHelper::getFaker()->languageCode, MockHelper::getFaker()->word);

        $displayNameCustomObject = $displayName->getCustom();

        $this->assertInstanceOf(DisplayNameCustom::class, $displayNameCustomObject);
    }

    public function testToString() {
        $name = MockHelper::getFaker()->word;

        $displayName = new DisplayName(MockHelper::getFaker()->languageCode, $name);

        $this->assertEquals($name, (string)$displayName);
    }

}