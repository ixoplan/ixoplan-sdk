<?php

namespace Ixolit\Dislo\Test;


use Ixolit\Dislo\FrontendClient;
use Ixolit\Dislo\Test\Request\TestRequestClient;
use Ixolit\Dislo\Test\Response\TestResponseInterface;
use Ixolit\Dislo\WorkingObjects\Billing\BillingEventObject;
use Ixolit\Dislo\WorkingObjects\Billing\BillingMethodObject;
use Ixolit\Dislo\WorkingObjects\Billing\ExternalProfileObject;
use Ixolit\Dislo\WorkingObjects\Billing\FlexibleObject;
use Ixolit\Dislo\WorkingObjects\Billing\RecurringObject;
use Ixolit\Dislo\WorkingObjects\Subscription\CouponObject;
use Ixolit\Dislo\WorkingObjects\Subscription\CouponUsageObject;
use Ixolit\Dislo\WorkingObjects\Subscription\DisplayNameObject;
use Ixolit\Dislo\WorkingObjects\Subscription\NextPackageObject;
use Ixolit\Dislo\WorkingObjects\Subscription\PackageObject;
use Ixolit\Dislo\WorkingObjects\Subscription\PackagePeriodObject;
use Ixolit\Dislo\WorkingObjects\Subscription\PeriodEventObject;
use Ixolit\Dislo\WorkingObjects\Subscription\PriceObject;
use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;
use Ixolit\Dislo\WorkingObjects\User\AuthTokenObject;
use Ixolit\Dislo\WorkingObjects\User\MetaProfileElementObject;
use Ixolit\Dislo\WorkingObjects\User\UserObject;
use PHPUnit\Framework\TestCase;


/**
 * Class AbstractTestCase
 *
 * @package Ixolit\Dislo\Test
 */
abstract class AbstractTestCase extends TestCase {

    /**
     * @param BillingMethodObject|null $billingMethod
     * @param BillingMethodObject|null $testBillingMethod
     *
     * @return $this
     */
    protected function compareBillingMethod(
        BillingMethodObject $billingMethod = null,
        BillingMethodObject $testBillingMethod = null
    ) {
        if ($this->compareNonObject($billingMethod, $testBillingMethod, BillingMethodObject::class)) {
            return $this;
        }

        $this->assertEquals($billingMethod->getBillingMethodId(), $testBillingMethod->getBillingMethodId());
        $this->assertEquals($billingMethod->getName(), $testBillingMethod->getName());
        $this->assertEquals($billingMethod->getDisplayName(), $testBillingMethod->getDisplayName());
        $this->assertEquals($billingMethod->isAvailable(), $testBillingMethod->isAvailable());
        $this->assertEquals($billingMethod->isCheckout(), $testBillingMethod->isCheckout());
        $this->assertEquals($billingMethod->isFlexible(), $testBillingMethod->isFlexible());
        $this->assertEquals($billingMethod->isRecurring(), $testBillingMethod->isRecurring());
        $this->assertEquals($billingMethod->isReplaceable(), $testBillingMethod->isReplaceable());

        return $this;
    }

    /**
     * @param FlexibleObject|null $flexible
     * @param FlexibleObject|null $testFlexible
     *
     * @return $this
     */
    protected function compareFlexible(
        FlexibleObject $flexible = null,
        FlexibleObject $testFlexible = null
    ) {
        if ($this->compareNonObject($flexible, $testFlexible, FlexibleObject::class)) {
            return $this;
        }

        $this->assertEquals($flexible->getFlexibleId(), $testFlexible->getFlexibleId());
        $this->assertEquals($flexible->getStatus(), $testFlexible->getStatus());
        $this->assertEmpty(\array_diff($flexible->getMetaData(), $testFlexible->getMetaData()));
        $this->assertEquals($flexible->getCreatedAt(), $testFlexible->getCreatedAt());
        $this->assertEquals($flexible->getBillingMethod(), $testFlexible->getBillingMethod());
        $this->compareBillingMethod($flexible->getBillingMethodObject(), $testFlexible->getBillingMethodObject());

        return $this;
    }

    /**
     * @param BillingEventObject|null $billingEvent
     * @param BillingEventObject|null $testBillingEvent
     *
     * @return $this
     */
    protected function compareBillingEvent(
        BillingEventObject $billingEvent = null,
        BillingEventObject $testBillingEvent = null
    ) {
        if ($this->compareNonObject($billingEvent, $testBillingEvent, BillingEventObject::class)) {
            return $this;
        }

        $this->assertEquals($billingEvent->getBillingEventId(), $testBillingEvent->getBillingEventId());
        $this->assertEquals($billingEvent->getUserId(), $testBillingEvent->getUserId());
        $this->assertEquals($billingEvent->getCurrencyCode(), $testBillingEvent->getCurrencyCode());
        $this->assertEquals($billingEvent->getCreatedAt(), $testBillingEvent->getCreatedAt());
        $this->assertEquals($billingEvent->getType(), $testBillingEvent->getType());
        $this->assertEquals($billingEvent->getStatus(), $testBillingEvent->getStatus());
        $this->assertEquals($billingEvent->getDescription(), $testBillingEvent->getDescription());
        $this->assertEquals($billingEvent->getTechinfo(), $testBillingEvent->getTechinfo());
        $this->assertEquals($billingEvent->getBillingMethod(), $testBillingEvent->getBillingMethod());
        $this->compareSubscription($billingEvent->getSubscription(), $testBillingEvent->getSubscription());
        $this->assertEquals($billingEvent->getModifiedAt(), $testBillingEvent->getModifiedAt());
        $this->compareBillingMethod($billingEvent->getBillingMethodObject(), $testBillingEvent->getBillingMethodObject());

        return $this;
    }

    /**
     * @param SubscriptionObject|null $subscription
     * @param SubscriptionObject|null $testSubscription
     *
     * @return $this
     */
    protected function compareSubscription(
        SubscriptionObject $subscription = null,
        SubscriptionObject $testSubscription = null
    ) {
        if ($this->compareNonObject($subscription, $testSubscription, SubscriptionObject::class)) {
            return $this;
        }

        $this->assertEquals($subscription->getSubscriptionId(), $testSubscription->getSubscriptionId());
        $this->comparePackage($subscription->getCurrentPackage(), $testSubscription->getCurrentPackage());
        $this->assertEquals($subscription->getUserId(), $testSubscription->getUserId());
        $this->assertEquals($subscription->getStatus(), $testSubscription->getStatus());
        $this->assertEquals($subscription->getStartedAt(), $testSubscription->getStartedAt());
        $this->assertEquals($subscription->getCanceledAt(), $testSubscription->getCanceledAt());
        $this->assertEquals($subscription->getClosedAt(), $testSubscription->getClosedAt());
        $this->assertEquals($subscription->getExpiresAt(), $testSubscription->getExpiresAt());
        $this->assertEquals($subscription->getNextBillingAt(), $testSubscription->getNextBillingAt());
        $this->assertEquals($subscription->isInitialPeriod(), $testSubscription->isInitialPeriod());
        $this->assertEquals($subscription->isProvisioned(), $testSubscription->isProvisioned());
        $this->assertEmpty(\array_diff($subscription->getProvisioningMetaData(), $testSubscription->getProvisioningMetaData()));
        $this->compareNextPackage($subscription->getNextPackage(), $testSubscription->getNextPackage());

        $testAddonSubscriptions = $testSubscription->getAddonSubscriptions();

        $this->assertEquals(\count($subscription->getAddonSubscriptions()), \count($testAddonSubscriptions));

        foreach ($subscription->getAddonSubscriptions() as $addonSubscription) {
            if (!isset($testAddonSubscriptions[$addonSubscription->getSubscriptionId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareSubscription($addonSubscription, $testAddonSubscriptions[$addonSubscription->getSubscriptionId()]);
        }

        $this->assertEquals($subscription->getMinimumTermEndsAt(), $testSubscription->getMinimumTermEndsAt());
        $this->assertEquals($subscription->isExternal(), $testSubscription->isExternal());
        $this->compareCouponUsage($subscription->getCouponUsage(), $testSubscription->getCouponUsage());
        $this->comparePeriodEvent($subscription->getCurrentPeriodEvent(), $testSubscription->getCurrentPeriodEvent());
        $this->assertEquals($subscription->getNextBillingAmount(), $testSubscription->getNextBillingAmount());

        return $this;
    }

    /**
     * @param PackageObject|null $package
     * @param PackageObject|null $testPackage
     *
     * @return $this
     */
    protected function comparePackage(PackageObject $package = null, PackageObject $testPackage = null) {
        if ($this->compareNonObject($package, $testPackage, PackageObject::class)) {
            return $this;
        }

        $this->assertEquals($package->getPackageIdentifier(), $testPackage->getPackageIdentifier());
        $this->assertEquals($package->getServiceIdentifier(), $testPackage->getServiceIdentifier());
        $this->assertEquals($package->getServiceIdentifier(), $testPackage->getServiceIdentifier());

        $testDisplayNames = $testPackage->getDisplayNames();

        $this->assertEquals(\count($package->getDisplayNames()), \count($testDisplayNames));

        foreach ($package->getDisplayNames() as $displayName) {
            if (!isset($testDisplayNames[$displayName->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($displayName, $testDisplayNames[$displayName->getName()]);
        }

        $this->assertEquals($package->isSignupAvailable(), $testPackage->isSignupAvailable());

        $testAddonPackages = $testPackage->getAddonPackages();

        $this->assertEquals(\count($package->getAddonPackages()), \count($testAddonPackages));

        foreach ($package->getAddonPackages() as $addonPackage) {
            if (!isset($testAddonPackages[$addonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($addonPackage, $testAddonPackages[$addonPackage->getPackageIdentifier()]);
        }

        $this->assertEmpty(\array_diff($package->getMetaData(), $testPackage->getMetaData()));
        $this->comparePackagePeriod($package->getInitialPeriod(), $testPackage->getInitialPeriod());
        $this->comparePackagePeriod($package->getRecurringPeriod(), $testPackage->getRecurringPeriod());
        $this->assertEquals($package->hasTrialPeriod(), $testPackage->hasTrialPeriod());

        $testBillingMethods = $testPackage->getBillingMethods();

        $this->assertEquals(\count($package->getBillingMethods()), \count($testBillingMethods));

        foreach ($package->getBillingMethods() as $billingMethod) {
            if (!isset($testBillingMethods[$billingMethod->getBillingMethodId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($billingMethod, $testBillingMethods[$billingMethod->getBillingMethodId()]);
        }

        $this->assertEquals($package->requiresFlexibleForFreeSignup(), $testPackage->requiresFlexibleForFreeSignup());

        return $this;
    }

    /**
     * @param NextPackageObject|null $nextPackage
     * @param NextPackageObject|null $testNextPackage
     *
     * @return $this
     */
    protected function compareNextPackage(
        NextPackageObject $nextPackage = null,
        NextPackageObject $testNextPackage = null
    ) {
        if ($this->compareNonObject($nextPackage, $testNextPackage, NextPackageObject::class)) {
            return $this;
        }

        $this->assertEquals($nextPackage->getPackageIdentifier(), $testNextPackage->getPackageIdentifier());
        $this->assertEquals($nextPackage->getServiceIdentifier(), $testNextPackage->getServiceIdentifier());
        $this->assertEquals($nextPackage->getServiceIdentifier(), $testNextPackage->getServiceIdentifier());

        $testDisplayNames = $testNextPackage->getDisplayNames();

        $this->assertEquals(\count($nextPackage->getDisplayNames()), \count($testDisplayNames));

        foreach ($nextPackage->getDisplayNames() as $displayName) {
            if (!isset($testDisplayNames[$displayName->getName()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($displayName, $testDisplayNames[$displayName->getName()]);
        }

        $testAddonPackages = $testNextPackage->getAddonPackages();

        $this->assertEquals($nextPackage->isSignupAvailable(), $testNextPackage->isSignupAvailable());

        foreach ($nextPackage->getAddonPackages() as $addonPackage) {
            if (!isset($testAddonPackages[$addonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($addonPackage, $testAddonPackages[$addonPackage->getPackageIdentifier()]);
        }

        $this->assertEmpty(\array_diff($nextPackage->getMetaData(), $testNextPackage->getMetaData()));

        $this->comparePackagePeriod($nextPackage->getInitialPeriod(), $testNextPackage->getInitialPeriod());
        $this->comparePackagePeriod($nextPackage->getRecurringPeriod(), $testNextPackage->getRecurringPeriod());
        $this->assertEquals($nextPackage->isPaid(), $testNextPackage->isPaid());
        $this->assertEquals($nextPackage->getEffectiveAt(), $testNextPackage->getEffectiveAt());

        return $this;
    }

    /**
     * @param PackagePeriodObject|null $packagePeriod
     * @param PackagePeriodObject|null $testPackagePeriod
     *
     * @return $this
     */
    protected function comparePackagePeriod(
        PackagePeriodObject $packagePeriod = null,
        PackagePeriodObject $testPackagePeriod = null
    ) {
        if ($this->compareNonObject($packagePeriod, $testPackagePeriod, PackagePeriodObject::class)) {
            return $this;
        }

        $this->assertEquals($packagePeriod->getLength(), $testPackagePeriod->getLength());
        $this->assertEquals($packagePeriod->getLengthUnit(), $testPackagePeriod->getLengthUnit());
        $this->assertEmpty(\array_diff($packagePeriod->getMetaData(), $testPackagePeriod->getMetaData()));

        $testPrices = $testPackagePeriod->getBasePrice();
        foreach ($packagePeriod->getBasePrice() as $price) {
            if (!isset($testPrices[$price->getTag()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($price, $testPrices[$price->getTag()]);
        }

        $this->assertEquals($packagePeriod->getMinimumTermLength(), $testPackagePeriod->getMinimumTermLength());

        return $this;
    }

    /**
     * @param PriceObject|null $price
     * @param PriceObject|null $testPrice
     *
     * @return $this
     */
    protected function comparePrice(PriceObject $price = null, PriceObject $testPrice = null) {
        if ($this->compareNonObject($price, $testPrice, PriceObject::class)) {
            return $this;
        }

        $this->assertEquals($price->getAmount(), $testPrice->getAmount());
        $this->assertEquals($price->getCurrencyCode(), $testPrice->getCurrencyCode());
        $this->assertEquals($price->getGroup(), $testPrice->getGroup());
        $this->assertEquals($price->getTag(), $testPrice->getTag());

        $testCompositePrices = $testPrice->getCompositePrices();
        foreach ($price->getCompositePrices() as $compositePrice) {
            if (!isset($testCompositePrices[$compositePrice->getTag()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($compositePrice, $testCompositePrices[$compositePrice->getTag()]);
        }

        return $this;
    }

    /**
     * @param CouponUsageObject|null $couponUsage
     * @param CouponUsageObject|null $testCouponUsage
     *
     * @return $this
     */
    protected function compareCouponUsage(
        CouponUsageObject $couponUsage = null,
        CouponUsageObject $testCouponUsage = null
    ) {
        if ($this->compareNonObject($couponUsage, $testCouponUsage, CouponUsageObject::class)) {
            return $this;
        }

        $this->compareCoupon($couponUsage->getCoupon(), $testCouponUsage->getCoupon());
        $this->assertEquals($couponUsage->getNumPeriods(), $testCouponUsage->getNumPeriods());
        $this->assertEquals($couponUsage->getCreatedAt(), $testCouponUsage->getCreatedAt());
        $this->assertEquals($couponUsage->getModifiedAt(), $testCouponUsage->getModifiedAt());

        return $this;
    }

    /**
     * @param CouponObject|null $coupon
     * @param CouponObject|null $testCoupon
     *
     * @return $this
     */
    protected function compareCoupon(CouponObject $coupon = null, CouponObject $testCoupon = null) {
        if ($this->compareNonObject($coupon, $testCoupon, CouponObject::class)) {
            return $this;
        }

        $this->assertEquals($coupon->getCode(), $testCoupon->getCode());
        $this->assertEquals($coupon->getDescription(), $testCoupon->getDescription());

        return $this;
    }

    /**
     * @param PeriodEventObject|null $periodEvent
     * @param PeriodEventObject|null $testPeriodEvent
     *
     * @return $this
     */
    protected function comparePeriodEvent(
        PeriodEventObject $periodEvent = null,
        PeriodEventObject $testPeriodEvent = null
    ) {
        if ($this->compareNonObject($periodEvent, $testPeriodEvent, PeriodEventObject::class)) {
            return $this;
        }

        $this->assertEquals($periodEvent->getPeriodEventId(), $testPeriodEvent->getPeriodEventId());
        $this->assertEquals($periodEvent->getPeriodId(), $testPeriodEvent->getPeriodId());
        $this->assertEquals($periodEvent->getSubscriptionHistoryId(), $testPeriodEvent->getSubscriptionHistoryId());
        $this->assertEquals($periodEvent->getStartedAt(), $testPeriodEvent->getStartedAt());
        $this->assertEquals($periodEvent->getEndsAt(), $testPeriodEvent->getEndsAt());
        $this->assertEquals($periodEvent->getParentPeriodEventId(), $testPeriodEvent->getParentPeriodEventId());
        $this->assertEquals($periodEvent->getOriginalEndsAt(), $testPeriodEvent->getOriginalEndsAt());

        return $this;
    }

    /**
     * @param DisplayNameObject|null $displayName
     * @param DisplayNameObject|null $testDisplayName
     *
     * @return $this
     */
    protected function compareDisplayName(
        DisplayNameObject $displayName = null,
        DisplayNameObject $testDisplayName = null
    ) {
        if ($this->compareNonObject($displayName, $testDisplayName, DisplayNameObject::class)) {
            return $this;
        }

        $this->assertEquals($displayName->getLanguage(), $testDisplayName->getLanguage());
        $this->assertEquals($displayName->getName(), $testDisplayName->getName());

        return $this;
    }

    /**
     * @param ExternalProfileObject|null $externalProfile
     * @param ExternalProfileObject|null $testExternalProfile
     *
     * @return $this
     */
    protected function compareExternalProfile(
        ExternalProfileObject $externalProfile = null,
        ExternalProfileObject $testExternalProfile = null
    ) {
        if ($this->compareNonObject($externalProfile, $testExternalProfile, ExternalProfileObject::class)) {
            return $this;
        }

        $this->assertEquals($externalProfile->getUserId(), $testExternalProfile->getUserId());
        $this->assertEquals($externalProfile->getSubscriptionId(), $testExternalProfile->getSubscriptionId());
        $this->assertEmpty(\array_diff($externalProfile->getExtraData(), $testExternalProfile->getExtraData()));
        $this->assertEquals($externalProfile->getExternalId(), $testExternalProfile->getExternalId());

        return $this;
    }

    /**
     * @param RecurringObject|null $recurring
     * @param RecurringObject|null $testRecurring
     *
     * @return $this
     */
    protected function compareRecurring(RecurringObject $recurring = null, RecurringObject $testRecurring = null) {
        if ($this->compareNonObject($recurring, $testRecurring, RecurringObject::class)) {
            return $this;
        }

        $this->assertEquals($recurring->getRecurringId(), $testRecurring->getRecurringId());
        $this->assertEquals($recurring->getStatus(), $testRecurring->getStatus());
        $this->assertEquals($recurring->getProviderToken(), $testRecurring->getProviderToken());
        $this->assertEquals($recurring->getCreatedAt(), $testRecurring->getCreatedAt());
        $this->assertEquals($recurring->getCanceledAt(), $testRecurring->getCanceledAt());
        $this->assertEquals($recurring->getClosedAt(), $testRecurring->getClosedAt());
        $this->assertEmpty(\array_diff($recurring->getParameters(), $testRecurring->getParameters()));
        $this->assertEquals($recurring->getAmount(), $testRecurring->getAmount());
        $this->assertEquals($recurring->getCurrency(), $testRecurring->getCurrency());

        return $this;
    }

    /**
     * @param UserObject|null $user
     * @param UserObject|null $testUser
     *
     * @return $this
     */
    protected function compareUser(UserObject $user = null, UserObject $testUser = null) {
        if ($this->compareNonObject($user, $testUser, UserObject::class)) {
            return $this;
        }

        $this->assertEquals($user->getUserId(), $testUser->getUserId());
        $this->assertEquals($user->getCreatedAt(), $testUser->getCreatedAt());
        $this->assertEquals($user->isLoginDisabled(), $testUser->isLoginDisabled());
        $this->assertEquals($user->getLanguage(), $testUser->getLanguage());
        $this->assertEquals($user->getLastLoginDate(), $testUser->getLastLoginDate());
        $this->assertEquals($user->getLastLoginIp(), $testUser->getLastLoginIp());
        $this->assertEmpty(\array_diff($user->getMetaData(), $testUser->getMetaData()));
        $this->assertEquals($user->getCurrencyCode(), $testUser->getCurrencyCode());
        $this->assertEmpty(\array_diff($user->getVerifiedData(), $testUser->getVerifiedData()));
        $this->compareAuthToken($user->getAuthToken(), $testUser->getAuthToken());

        return $this;
    }

    /**
     * @param AuthTokenObject|null $authToken
     * @param AuthTokenObject|null $testAuthToken
     *
     * @return $this
     */
    protected function compareAuthToken(AuthTokenObject $authToken = null, AuthTokenObject $testAuthToken = null) {
        if ($this->compareNonObject($authToken, $testAuthToken, AuthTokenObject::class)) {
            return $this;
        }

        $this->assertEquals($authToken->getId(), $testAuthToken->getId());
        $this->assertEquals($authToken->getUserId(), $testAuthToken->getUserId());
        $this->assertEquals($authToken->getToken(), $testAuthToken->getToken());
        $this->assertEquals($authToken->getCreatedAt(), $testAuthToken->getCreatedAt());
        $this->assertEquals($authToken->getModifiedAt(), $testAuthToken->getModifiedAt());
        $this->assertEquals($authToken->getValidUntil(), $testAuthToken->getValidUntil());
        $this->assertEquals($authToken->getMetaInfo(), $testAuthToken->getMetaInfo());

        return $this;
    }

    /**
     * @param MetaProfileElementObject|null $metaProfileElement
     * @param MetaProfileElementObject|null $testMetaProfileElement
     *
     * @return $this
     */
    protected function compareMetaProfileElement(
        MetaProfileElementObject $metaProfileElement = null,
        MetaProfileElementObject $testMetaProfileElement = null
    ) {
        if (
            $this->compareNonObject($metaProfileElement, $testMetaProfileElement, MetaProfileElementObject::class)
        ) {
            return $this;
        }

        $this->assertEquals($metaProfileElement->getName(), $testMetaProfileElement->getName());
        $this->assertEquals($metaProfileElement->isRequired(), $testMetaProfileElement->isRequired());
        $this->assertEquals($metaProfileElement->isUnique(), $testMetaProfileElement->isUnique());

        return $this;
    }

    /**
     * @param mixed  $response
     * @param mixed  $testResponse
     * @param string $class
     *
     * @return bool
     */
    protected function compareNonObject($response, $testResponse, $class) {
        if (!(($response instanceof $class) && ($testResponse instanceof $class))) {
            $this->assertEquals($response, $testResponse);

            return true;
        }

        return false;
    }

    /**
     * @param string $methodName
     * @param string $class
     *
     * @return \ReflectionMethod
     */
    protected function getAccessibleMethod($methodName, $class) {
        $frontendClientClass = new \ReflectionClass($class);

        $method = $frontendClientClass->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @param array|TestResponseInterface $response
     * @param bool                        $forceTokenMode
     *
     * @return FrontendClient
     */
    protected function createFrontendClient($response = [], $forceTokenMode = true) {
        return new FrontendClient(
            $this->createTestRequestClient($response),
            $forceTokenMode
        );
    }

    /**
     * @param  array|TestResponseInterface $response
     *
     * @return TestRequestClient
     */
    protected function createTestRequestClient($response) {
        return new TestRequestClient($response);
    }

}