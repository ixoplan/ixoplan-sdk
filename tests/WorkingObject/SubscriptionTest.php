<?php
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\CouponUsageMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\NextPackageMock;
use Ixolit\Dislo\Test\WorkingObjects\PackageMock;
use Ixolit\Dislo\Test\WorkingObjects\PeriodEventMock;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\CouponUsage;
use Ixolit\Dislo\WorkingObjects\NextPackage;
use Ixolit\Dislo\WorkingObjects\Package;
use Ixolit\Dislo\WorkingObjects\PeriodEvent;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjectsCustom\SubscriptionCustom;

/**
 * Class SubscriptionTest
 */
class SubscriptionTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscriptionId       = MockHelper::getFaker()->uuid;
        $currentPackage       = PackageMock::create();
        $userId               = MockHelper::getFaker()->uuid;
        $status               = SubscriptionMock::randomState();
        $startedAt            = MockHelper::getFaker()->dateTime();
        $canceledAt           = MockHelper::getFaker()->dateTime();
        $closedAt             = MockHelper::getFaker()->dateTime();
        $expiresAt            = MockHelper::getFaker()->dateTime();
        $nextBillingAt        = MockHelper::getFaker()->dateTime();
        $currencyCode         = MockHelper::getFaker()->currencyCode;
        $isInitialPeriod      = MockHelper::getFaker()->boolean();
        $isProvisioned        = MockHelper::getFaker()->boolean();
        $provisioningMetaData = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $nextPackage          = NextPackageMock::create();

        $addonSubscription    = SubscriptionMock::create();
        $addonSubscriptions   = [
            $addonSubscription->getSubscriptionId() => $addonSubscription,
        ];
        $minimumTermEndsAt    = MockHelper::getFaker()->dateTime();
        $isExternal           = MockHelper::getFaker()->boolean();
        $couponUsage          = CouponUsageMock::create();
        $currentPeriodEvent   = PeriodEventMock::create();
        $nextBillingAmount    = MockHelper::getFaker()->randomFloat();

        $subscription = new Subscription(
            $subscriptionId,
            $currentPackage,
            $userId,
            $status,
            $startedAt,
            $canceledAt,
            $closedAt,
            $expiresAt,
            $nextBillingAt,
            $currencyCode,
            $isInitialPeriod,
            $isProvisioned,
            $provisioningMetaData,
            $nextPackage,
            $addonSubscriptions,
            $minimumTermEndsAt,
            $isExternal,
            $couponUsage,
            $currentPeriodEvent,
            $nextBillingAmount
        );

        $reflectionObject = new \ReflectionObject($subscription);

        $subscriptionIdProperty = $reflectionObject->getProperty('subscriptionId');
        $subscriptionIdProperty->setAccessible(true);
        $this->assertEquals($subscriptionId, $subscriptionIdProperty->getValue($subscription));

        $currentPackageProperty = $reflectionObject->getProperty('currentPackage');
        $currentPackageProperty->setAccessible(true);
        $this->comparePackage($currentPackageProperty->getValue($subscription), $currentPackage);

        $userIdProperty = $reflectionObject->getProperty('userId');
        $userIdProperty->setAccessible(true);
        $this->assertEquals($userId, $userIdProperty->getValue($subscription));

        $statusProperty = $reflectionObject->getProperty('status');
        $statusProperty->setAccessible(true);
        $this->assertEquals($status, $statusProperty->getValue($subscription));

        $startedAtProperty = $reflectionObject->getProperty('startedAt');
        $startedAtProperty->setAccessible(true);
        $this->assertEquals($startedAt, $startedAtProperty->getValue($subscription));

        $canceledAtProperty = $reflectionObject->getProperty('canceledAt');
        $canceledAtProperty->setAccessible(true);
        $this->assertEquals($canceledAt, $canceledAtProperty->getValue($subscription));

        $closedAtProperty = $reflectionObject->getProperty('closedAt');
        $closedAtProperty->setAccessible(true);
        $this->assertEquals($closedAt, $closedAtProperty->getValue($subscription));

        $expiresAtProperty = $reflectionObject->getProperty('expiresAt');
        $expiresAtProperty->setAccessible(true);
        $this->assertEquals($expiresAt, $expiresAtProperty->getValue($subscription));

        $nextBillingAtProperty = $reflectionObject->getProperty('nextBillingAt');
        $nextBillingAtProperty->setAccessible(true);
        $this->assertEquals($nextBillingAt, $nextBillingAtProperty->getValue($subscription));

        $currencyCodeProperty = $reflectionObject->getProperty('currencyCode');
        $currencyCodeProperty->setAccessible(true);
        $this->assertEquals($currencyCode, $currencyCodeProperty->getValue($subscription));

        $isInitialPeriodProperty = $reflectionObject->getProperty('isInitialPeriod');
        $isInitialPeriodProperty->setAccessible(true);
        $this->assertEquals($isInitialPeriod, $isInitialPeriodProperty->getValue($subscription));

        $isProvisionedProperty = $reflectionObject->getProperty('isProvisioned');
        $isProvisionedProperty->setAccessible(true);
        $this->assertEquals($isProvisioned, $isProvisionedProperty->getValue($subscription));

        $provisioningMetaDataProperty = $reflectionObject->getProperty('provisioningMetaData');
        $provisioningMetaDataProperty->setAccessible(true);
        $this->assertEquals($provisioningMetaData, $provisioningMetaDataProperty->getValue($subscription));

        $nextPackageProperty = $reflectionObject->getProperty('nextPackage');
        $nextPackageProperty->setAccessible(true);
        $this->compareNextPackage($nextPackageProperty->getValue($subscription), $nextPackage);

        $addonSubscriptionsProperty = $reflectionObject->getProperty('addonSubscriptions');
        $addonSubscriptionsProperty->setAccessible(true);

        /** @var Subscription[] $testAddonSubscriptions */
        $testAddonSubscriptions = $addonSubscriptionsProperty->getValue($subscription);
        foreach ($testAddonSubscriptions as $testAddonSubscription) {
            if (empty($addonSubscriptions[$testAddonSubscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($testAddonSubscription, $addonSubscriptions[$testAddonSubscription->getSubscriptionId()]);
        }

        $minimumTermEndsAtProperty = $reflectionObject->getProperty('minimumTermEndsAt');
        $minimumTermEndsAtProperty->setAccessible(true);
        $this->assertEquals($minimumTermEndsAt, $minimumTermEndsAtProperty->getValue($subscription));

        $isExternalProperty = $reflectionObject->getProperty('isExternal');
        $isExternalProperty->setAccessible(true);
        $this->assertEquals($isExternal, $isExternalProperty->getValue($subscription));

        $couponUsageProperty = $reflectionObject->getProperty('couponUsage');
        $couponUsageProperty->setAccessible(true);
        $this->compareCouponUsage($couponUsageProperty->getValue($subscription), $couponUsage);

        $currentPeriodEventProperty = $reflectionObject->getProperty('currentPeriodEvent');
        $currentPeriodEventProperty->setAccessible(true);
        $this->comparePeriodEvent($currentPeriodEventProperty->getValue($subscription), $currentPeriodEvent);

        $nextBillingAmountProperty = $reflectionObject->getProperty('nextBillingAmount');
        $nextBillingAmountProperty->setAccessible(true);
        $this->assertEquals($nextBillingAmount, $nextBillingAmountProperty->getValue($subscription));

        new Subscription(
            $subscriptionId,
            $currentPackage,
            $userId,
            $status,
            $startedAt,
            $canceledAt,
            $closedAt,
            $expiresAt,
            $nextBillingAt,
            $currencyCode,
            $isInitialPeriod,
            $isProvisioned,
            $provisioningMetaData,
            $nextPackage,
            $addonSubscriptions
        );
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscriptionId       = MockHelper::getFaker()->uuid;
        $currentPackage       = PackageMock::create();
        $userId               = MockHelper::getFaker()->uuid;
        $status               = SubscriptionMock::randomState();
        $startedAt            = MockHelper::getFaker()->dateTime();
        $canceledAt           = MockHelper::getFaker()->dateTime();
        $closedAt             = MockHelper::getFaker()->dateTime();
        $expiresAt            = MockHelper::getFaker()->dateTime();
        $nextBillingAt        = MockHelper::getFaker()->dateTime();
        $currencyCode         = MockHelper::getFaker()->currencyCode;
        $isInitialPeriod      = MockHelper::getFaker()->boolean();
        $isProvisioned        = MockHelper::getFaker()->boolean();

        $metaDataName = MockHelper::getFaker()->uuid;
        $metaDataEntry = MockHelper::getFaker()->word;
        $provisioningMetaData = [
            $metaDataName => $metaDataEntry,
        ];
        $nextPackage          = NextPackageMock::create();

        $addonSubscription    = SubscriptionMock::create();
        $addonSubscriptions   = [
            $addonSubscription->getSubscriptionId() => $addonSubscription,
        ];
        $minimumTermEndsAt    = MockHelper::getFaker()->dateTime();
        $isExternal           = MockHelper::getFaker()->boolean();
        $couponUsage          = CouponUsageMock::create();
        $currentPeriodEvent   = PeriodEventMock::create();
        $nextBillingAmount    = MockHelper::getFaker()->randomFloat();

        $subscription = new Subscription(
            $subscriptionId,
            $currentPackage,
            $userId,
            $status,
            $startedAt,
            $canceledAt,
            $closedAt,
            $expiresAt,
            $nextBillingAt,
            $currencyCode,
            $isInitialPeriod,
            $isProvisioned,
            $provisioningMetaData,
            $nextPackage,
            $addonSubscriptions,
            $minimumTermEndsAt,
            $isExternal,
            $couponUsage,
            $currentPeriodEvent,
            $nextBillingAmount
        );

        $this->assertEquals($subscriptionId, $subscription->getSubscriptionId());
        $this->comparePackage($subscription->getCurrentPackage(), $currentPackage);
        $this->assertEquals($userId, $subscription->getUserId());
        $this->assertEquals($status, $subscription->getStatus());
        $this->assertEquals($startedAt, $subscription->getStartedAt());
        $this->assertEquals($canceledAt, $subscription->getCanceledAt());
        $this->assertEquals($closedAt, $subscription->getClosedAt());
        $this->assertEquals($expiresAt, $subscription->getExpiresAt());
        $this->assertEquals($nextBillingAt, $subscription->getNextBillingAt());
        $this->assertEquals($currencyCode, $subscription->getCurrencyCode());
        $this->assertEquals($isInitialPeriod, $subscription->isInitialPeriod());
        $this->assertEquals(!empty($provisioningMetaData), $subscription->isProvisioned());
        $this->assertEquals($provisioningMetaData, $subscription->getProvisioningMetaData());
        $this->compareNextPackage($subscription->getNextPackage(), $nextPackage);

        $testAddonSubscriptions = $subscription->getAddonSubscriptions();
        foreach ($testAddonSubscriptions as $testAddonSubscription) {
            if (empty($addonSubscriptions[$testAddonSubscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($testAddonSubscription, $addonSubscriptions[$testAddonSubscription->getSubscriptionId()]);
        }

        $this->assertEquals($minimumTermEndsAt, $subscription->getMinimumTermEndsAt());
        $this->assertEquals($isExternal, $subscription->isExternal());
        $this->compareCouponUsage($subscription->getCouponUsage(), $couponUsage);
        $this->comparePeriodEvent($subscription->getCurrentPeriodEvent(), $currentPeriodEvent);
        $this->assertEquals($nextBillingAmount, $subscription->getNextBillingAmount());

        $this->assertEquals(!empty($provisioningMetaData), $subscription->isIsProvisioned());
        $this->assertEquals($metaDataEntry, $subscription->getProvisioningMetaDataEntry($metaDataName));

        $currentPeriod = $isInitialPeriod
            ? $currentPackage->getInitialPeriod()
            : $currentPackage->getRecurringPeriod();
        $this->comparePackagePeriod($currentPeriod, $subscription->getCurrentPeriod());

        $isInPaidPeriod = \in_array($status, [
            Subscription::STATUS_RUNNING,
            Subscription::STATUS_CANCELED,
            Subscription::STATUS_SUSPENDED_RUNNING,
            Subscription::STATUS_SUSPENDED_RUNNING,
        ])
            ? $currentPeriod->isPaid()
            : false;
        $this->assertEquals($isInPaidPeriod, $subscription->isInPaidPeriod());

        $this->assertEquals(
            \in_array($status, [
                Subscription::STATUS_RUNNING,
                Subscription::STATUS_CANCELED,
                Subscription::STATUS_SUSPENDED_RUNNING,
                Subscription::STATUS_SUSPENDED_RUNNING,
            ]),
            $subscription->isActive()
        );
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $currentPackage       = PackageMock::create();
        $startedAt            = MockHelper::getFaker()->dateTime();
        $canceledAt           = MockHelper::getFaker()->dateTime();
        $closedAt             = MockHelper::getFaker()->dateTime();
        $expiresAt            = MockHelper::getFaker()->dateTime();
        $nextBillingAt        = MockHelper::getFaker()->dateTime();
        $nextPackage          = NextPackageMock::create();

        $addonSubscription    = SubscriptionMock::create();
        $addonSubscriptions   = [
            $addonSubscription->getSubscriptionId() => $addonSubscription,
        ];
        $couponUsage          = CouponUsageMock::create();
        $currentPeriodEvent   = PeriodEventMock::create();
        $minimumTermEndsAt    = MockHelper::getFaker()->dateTime();

        $response = [
            'subscriptionId'       => MockHelper::getFaker()->uuid,
            'currentPackage'       => $currentPackage->toArray(),
            'userId'               => MockHelper::getFaker()->uuid,
            'status'               => SubscriptionMock::randomState(),
            'startedAt'            => $startedAt->format('Y-m-d H:i:s'),
            'canceledAt'           => $canceledAt->format('Y-m-d H:i:s'),
            'closedAt'             => $closedAt->format('Y-m-d H:i:s'),
            'expiresAt'            => $expiresAt->format('Y-m-d H:i:s'),
            'nextBillingAt'        => $nextBillingAt->format('Y-m-d H:i:s'),
            'nextBillingAmount'    => MockHelper::getFaker()->randomFloat(),
            'currencyCode'         => MockHelper::getFaker()->currencyCode,
            'isInitialPeriod'      => MockHelper::getFaker()->boolean(),
            'isProvisioned'        => MockHelper::getFaker()->boolean(),
            'isExternal'           => MockHelper::getFaker()->boolean(),
            'provisioningMetaData' => [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            'nextPackage'          => $nextPackage->toArray(),
            'addonSubscriptions'   => \array_map(
                function($addonSubscription) {
                    /** @var Subscription $addonSubscription */
                    return $addonSubscription->toArray();
                },
                $addonSubscriptions
            ),
            'minimumTermEndsAt'    => $minimumTermEndsAt->format('Y-m-d H:i:s'),
            'couponUsage'          => $couponUsage->toArray(),
            'currentPeriodEvent'   => $currentPeriodEvent->toArray(),
        ];

        $subscription = Subscription::fromResponse($response);

        $this->assertEquals($response['subscriptionId'], $subscription->getSubscriptionId());
        $this->comparePackage($subscription->getCurrentPackage(), $currentPackage);
        $this->assertEquals($response['userId'], $subscription->getUserId());
        $this->assertEquals($response['status'], $subscription->getStatus());
        $this->assertEquals($startedAt, $subscription->getStartedAt());
        $this->assertEquals($canceledAt, $subscription->getCanceledAt());
        $this->assertEquals($closedAt, $subscription->getClosedAt());
        $this->assertEquals($expiresAt, $subscription->getExpiresAt());
        $this->assertEquals($nextBillingAt, $subscription->getNextBillingAt());
        $this->assertEquals($response['nextBillingAmount'], $subscription->getNextBillingAmount());
        $this->assertEquals($response['currencyCode'], $subscription->getCurrencyCode());
        $this->assertEquals($response['isInitialPeriod'], $subscription->isInitialPeriod());

        $reflectionObject = new \ReflectionObject($subscription);

        $isProvisionedProperty = $reflectionObject->getProperty('isProvisioned');
        $isProvisionedProperty->setAccessible(true);
        $this->assertEquals($response['isProvisioned'], $isProvisionedProperty->getValue($subscription));

        $this->assertEquals($response['isExternal'], $subscription->isExternal());
        $this->assertEquals($response['provisioningMetaData'], $subscription->getProvisioningMetaData());
        $this->compareNextPackage($subscription->getNextPackage(), $nextPackage);

        $testAddonSubscriptions = $subscription->getAddonSubscriptions();
        foreach ($testAddonSubscriptions as $testAddonSubscription) {
            if (empty($addonSubscriptions[$testAddonSubscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($testAddonSubscription, $addonSubscriptions[$testAddonSubscription->getSubscriptionId()]);
        }

        $this->assertEquals($minimumTermEndsAt, $subscription->getMinimumTermEndsAt());
        $this->compareCouponUsage($subscription->getCouponUsage(), $couponUsage);
        $this->comparePeriodEvent($subscription->getCurrentPeriodEvent(), $currentPeriodEvent);
    }

    /**
     * @return void
     */
    public function testToArray() {
        $currentPackage       = PackageMock::create();
        $startedAt            = MockHelper::getFaker()->dateTime();
        $canceledAt           = MockHelper::getFaker()->dateTime();
        $closedAt             = MockHelper::getFaker()->dateTime();
        $expiresAt            = MockHelper::getFaker()->dateTime();
        $nextBillingAt        = MockHelper::getFaker()->dateTime();
        $nextPackage          = NextPackageMock::create();
        $isProvisioned        = MockHelper::getFaker()->boolean();

        $addonSubscription    = SubscriptionMock::create();
        $addonSubscriptions   = [
            $addonSubscription->getSubscriptionId() => $addonSubscription,
        ];
        $minimumTermEndsAt    = MockHelper::getFaker()->dateTime();
        $couponUsage          = CouponUsageMock::create();
        $currentPeriodEvent   = PeriodEventMock::create();

        $subscription = new Subscription(
            MockHelper::getFaker()->uuid,
            $currentPackage,
            MockHelper::getFaker()->uuid,
            SubscriptionMock::randomState(),
            $startedAt,
            $canceledAt,
            $closedAt,
            $expiresAt,
            $nextBillingAt,
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->boolean(),
            $isProvisioned,
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            $nextPackage,
            $addonSubscriptions,
            $minimumTermEndsAt,
            MockHelper::getFaker()->boolean(),
            $couponUsage,
            $currentPeriodEvent,
            MockHelper::getFaker()->randomFloat()
        );

        $subscriptionArray = $subscription->toArray();

        $this->assertEquals($subscription->getSubscriptionId(), $subscriptionArray['subscriptionId']);
        $this->comparePackage(Package::fromResponse($subscriptionArray['currentPackage']), $currentPackage);
        $this->assertEquals($subscription->getUserId(), $subscriptionArray['userId']);
        $this->assertEquals($subscription->getStatus(), $subscriptionArray['status']);
        $this->assertEquals($startedAt->format('Y-m-d H:i:s'), $subscriptionArray['startedAt']);
        $this->assertEquals($canceledAt->format('Y-m-d H:i:s'), $subscriptionArray['canceledAt']);
        $this->assertEquals($closedAt->format('Y-m-d H:i:s'), $subscriptionArray['closedAt']);
        $this->assertEquals($expiresAt->format('Y-m-d H:i:s'), $subscriptionArray['expiresAt']);
        $this->assertEquals($nextBillingAt->format('Y-m-d H:i:s'), $subscriptionArray['nextBillingAt']);
        $this->assertEquals($subscription->getCurrencyCode(), $subscriptionArray['currencyCode']);
        $this->assertEquals($subscription->isInitialPeriod(), $subscriptionArray['isInitialPeriod']);
        $this->assertEquals($isProvisioned, $subscriptionArray['isProvisioned']);
        $this->assertEquals($subscription->getProvisioningMetaData(), $subscriptionArray['provisioningMetaData']);
        $this->compareNextPackage(NextPackage::fromResponse($subscriptionArray['nextPackage']), $nextPackage);

        $testAddonSubscriptions = $subscriptionArray['addonSubscriptions'];
        foreach ($testAddonSubscriptions as $testAddonSubscription) {
            $testAddonSubscription = Subscription::fromResponse($testAddonSubscription);

            if (empty($addonSubscriptions[$testAddonSubscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($testAddonSubscription, $addonSubscriptions[$testAddonSubscription->getSubscriptionId()]);
        }

        $this->assertEquals($minimumTermEndsAt->format('Y-m-d H:i:s'), $subscriptionArray['minimumTermEndsAt']);
        $this->assertEquals($subscription->isExternal(), $subscriptionArray['isExternal']);
        $this->compareCouponUsage(CouponUsage::fromResponse($subscriptionArray['couponUsage']), $couponUsage);
        $this->comparePeriodEvent(PeriodEvent::fromResponse($subscriptionArray['currentPeriodEvent']), $currentPeriodEvent);
        $this->assertEquals($subscription->getNextBillingAmount(), $subscriptionArray['nextBillingAmount']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $subscription = new Subscription(
            MockHelper::getFaker()->uuid,
            PackageMock::create(),
            MockHelper::getFaker()->uuid,
            SubscriptionMock::randomState(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean(),
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            NextPackageMock::create(),
            [
                SubscriptionMock::create(),
            ],
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->boolean(),
            CouponUsageMock::create(),
            PeriodEventMock::create(),
            MockHelper::getFaker()->randomFloat()
        );

        $subscriptionCustomObject = $subscription->getCustom();

        $this->assertInstanceOf(SubscriptionCustom::class, $subscriptionCustomObject);
    }

}