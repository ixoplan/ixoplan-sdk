<?php
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\CouponMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\Coupon;
use Ixolit\Dislo\WorkingObjects\CouponUsage;
use Ixolit\Dislo\WorkingObjectsCustom\CouponUsageCustom;

/**
 * Class CouponUsageTest
 */
class CouponUsageTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $coupon     = CouponMock::create();
        $numPeriods = MockHelper::getFaker()->numberBetween();
        $createdAt  = MockHelper::getFaker()->dateTime();
        $modifiedAt = MockHelper::getFaker()->dateTime();

        $couponUsage = new CouponUsage(
            $coupon,
            $numPeriods,
            $createdAt,
            $modifiedAt
        );

        $reflectionObject = new \ReflectionObject($couponUsage);

        $couponProperty = $reflectionObject->getProperty('coupon');
        $couponProperty->setAccessible(true);
        $this->compareCoupon($couponProperty->getValue($couponUsage), $coupon);

        $numPeriodsProperty = $reflectionObject->getProperty('numPeriods');
        $numPeriodsProperty->setAccessible(true);
        $this->assertEquals($numPeriods, $numPeriodsProperty->getValue($couponUsage));

        $createdAtProperty = $reflectionObject->getProperty('createdAt');
        $createdAtProperty->setAccessible(true);
        $this->assertEquals($createdAt, $createdAtProperty->getValue($couponUsage));

        $modifiedAtProperty = $reflectionObject->getProperty('modifiedAt');
        $modifiedAtProperty->setAccessible(true);
        $this->assertEquals($modifiedAt, $modifiedAtProperty->getValue($couponUsage));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $coupon     = CouponMock::create();
        $numPeriods = MockHelper::getFaker()->numberBetween();
        $createdAt  = MockHelper::getFaker()->dateTime();
        $modifiedAt = MockHelper::getFaker()->dateTime();

        $couponUsage = new CouponUsage(
            $coupon,
            $numPeriods,
            $createdAt,
            $modifiedAt
        );

        $this->compareCoupon($couponUsage->getCoupon(), $coupon);
        $this->assertEquals($numPeriods, $couponUsage->getNumPeriods());
        $this->assertEquals($createdAt, $couponUsage->getCreatedAt());
        $this->assertEquals($modifiedAt, $couponUsage->getModifiedAt());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $coupon     = CouponMock::create();
        $createdAt  = MockHelper::getFaker()->dateTime();
        $modifiedAt = MockHelper::getFaker()->dateTime();

        $response = [
            'coupon'     => $coupon->toArray(),
            'numPeriods' => MockHelper::getFaker()->randomNumber(),
            'createdAt'  => $createdAt->format('Y-m-d H:i:s'),
            'modifiedAt' => $modifiedAt->format('Y-m-d H:i:s'),
        ];

        $couponUsage = CouponUsage::fromResponse($response);

        $this->compareCoupon($couponUsage->getCoupon(), $coupon);
        $this->assertEquals($response['numPeriods'], $couponUsage->getNumPeriods());
        $this->assertEquals($createdAt, $couponUsage->getCreatedAt());
        $this->assertEquals($modifiedAt, $couponUsage->getModifiedAt());
    }

    /**
     * @return void
     */
    public function testToArray() {
        $coupon     = CouponMock::create();
        $createdAt  = MockHelper::getFaker()->dateTime();
        $modifiedAt = MockHelper::getFaker()->dateTime();

        $couponUsage = new CouponUsage(
            $coupon,
            MockHelper::getFaker()->numberBetween(),
            $createdAt,
            $modifiedAt
        );

        $couponUsageArray = $couponUsage->toArray();

        $this->compareCoupon(Coupon::fromResponse($couponUsageArray['coupon']), $coupon);
        $this->assertEquals($couponUsage->getNumPeriods(), $couponUsageArray['numPeriods']);
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $couponUsageArray['createdAt']);
        $this->assertEquals($modifiedAt->format('Y-m-d H:i:s'), $couponUsageArray['modifiedAt']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $couponUsage = new CouponUsage(
            CouponMock::create(),
            MockHelper::getFaker()->numberBetween(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime()
        );

        $couponUsageCustomObject = $couponUsage->getCustom();

        $this->assertInstanceOf(CouponUsageCustom::class, $couponUsageCustomObject);
    }

}