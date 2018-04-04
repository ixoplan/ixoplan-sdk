<?php
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\Coupon;
use Ixolit\Dislo\WorkingObjectsCustom\CouponCustom;

/**
 * Class CouponTest
 */
class CouponTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $code        = MockHelper::getFaker()->uuid;
        $description = MockHelper::getFaker()->words();

        $coupon = new Coupon($code, $description);

        $reflectionObject = new \ReflectionObject($coupon);

        $codeProperty = $reflectionObject->getProperty('code');
        $codeProperty->setAccessible(true);
        $this->assertEquals($code, $codeProperty->getValue($coupon));

        $descriptionProperty = $reflectionObject->getProperty('description');
        $descriptionProperty->setAccessible(true);
        $this->assertEquals($description, $descriptionProperty->getValue($coupon));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $code        = MockHelper::getFaker()->uuid;
        $description = MockHelper::getFaker()->words();

        $coupon = new Coupon($code, $description);

        $this->assertEquals($code, $coupon->getCode());
        $this->assertEquals($description, $coupon->getDescription());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $response = [
            'code'        => MockHelper::getFaker()->uuid,
            'description' => MockHelper::getFaker()->words(),
        ];

        $coupon = Coupon::fromResponse($response);

        $this->assertEquals($response['code'], $coupon->getCode());
        $this->assertEquals($response['description'], $coupon->getDescription());
    }

    /**
     * @return void
     */
    public function testToArray() {
        $coupon = new Coupon(MockHelper::getFaker()->uuid, MockHelper::getFaker()->words());

        $couponArray = $coupon->toArray();

        $this->assertEquals($coupon->getCode(), $couponArray['code']);
        $this->assertEquals($coupon->getDescription(), $couponArray['description']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $coupon = new Coupon(MockHelper::getFaker()->uuid, MockHelper::getFaker()->words());

        $couponCustomObject = $coupon->getCustom();

        $this->assertInstanceOf(CouponCustom::class, $couponCustomObject);
    }

}