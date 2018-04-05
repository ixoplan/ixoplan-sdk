<?php
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\MetaProfileElement;
use Ixolit\Dislo\WorkingObjectsCustom\MetaProfileElementCustom;

/**
 * Class MetaProfileElementTest
 */
class MetaProfileElementTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $name     = MockHelper::getFaker()->uuid;
        $required = MockHelper::getFaker()->boolean();
        $unique   = MockHelper::getFaker()->boolean();

        $metaProfileElement = new MetaProfileElement($name, $required, $unique);

        $reflectionObject = new \ReflectionObject($metaProfileElement);

        $nameProperty = $reflectionObject->getProperty('name');
        $nameProperty->setAccessible(true);
        $this->assertEquals($name, $nameProperty->getValue($metaProfileElement));

        $requiredProperty = $reflectionObject->getProperty('required');
        $requiredProperty->setAccessible(true);
        $this->assertEquals($required, $requiredProperty->getValue($metaProfileElement));

        $uniqueProperty = $reflectionObject->getProperty('unique');
        $uniqueProperty->setAccessible(true);
        $this->assertEquals($unique, $uniqueProperty->getValue($metaProfileElement));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $name     = MockHelper::getFaker()->uuid;
        $required = MockHelper::getFaker()->boolean();
        $unique   = MockHelper::getFaker()->boolean();

        $metaProfileElement = new MetaProfileElement($name, $required, $unique);

        $this->assertEquals($name, $metaProfileElement->getName());
        $this->assertEquals($required, $metaProfileElement->isRequired());
        $this->assertEquals($unique, $metaProfileElement->isUnique());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $response = [
            'name'     => MockHelper::getFaker()->uuid,
            'unique'   => MockHelper::getFaker()->boolean(),
            'required' => MockHelper::getFaker()->boolean(),
        ];

        $metaProfileElement = MetaProfileElement::fromResponse($response);

        $this->assertEquals($response['name'], $metaProfileElement->getName());
        $this->assertEquals($response['unique'], $metaProfileElement->isUnique());
        $this->assertEquals($response['required'], $metaProfileElement->isRequired());
    }

    /**
     * @rturn void
     */
    public function testToArray() {
        $metaProfileElement = new MetaProfileElement(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean()
        );

        $metaProfileElementArray = $metaProfileElement->toArray();

        $this->assertEquals($metaProfileElement->getName(), $metaProfileElementArray['name']);
        $this->assertEquals($metaProfileElement->isUnique(), $metaProfileElementArray['unique']);
        $this->assertEquals($metaProfileElement->isRequired(), $metaProfileElementArray['required']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $metaProfileElement = new MetaProfileElement(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean()
        );

        $metaProfileElementCustomObject = $metaProfileElement->getCustom();

        $this->assertInstanceOf(MetaProfileElementCustom::class, $metaProfileElementCustomObject);
    }

}