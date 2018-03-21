<?php

namespace Ixolit\Dislo\Test;


use Ixolit\Dislo\Client;
use Ixolit\Dislo\Test\Request\TestRequestClient;
use Ixolit\Dislo\Test\Response\TestResponseInterface;
use Ixolit\Dislo\WorkingObjects\AuthToken;
use Ixolit\Dislo\WorkingObjects\BillingEvent;
use Ixolit\Dislo\WorkingObjects\BillingMethod;
use Ixolit\Dislo\WorkingObjects\Coupon;
use Ixolit\Dislo\WorkingObjects\CouponUsage;
use Ixolit\Dislo\WorkingObjects\DisplayName;
use Ixolit\Dislo\WorkingObjects\ExternalProfile;
use Ixolit\Dislo\WorkingObjects\Flexible;
use Ixolit\Dislo\WorkingObjects\MetaProfileElement;
use Ixolit\Dislo\WorkingObjects\NextPackage;
use Ixolit\Dislo\WorkingObjects\Package;
use Ixolit\Dislo\WorkingObjects\PackagePeriod;
use Ixolit\Dislo\WorkingObjects\PeriodEvent;
use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Recurring;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjects\User;
use PHPUnit\Framework\TestCase;


/**
 * Class AbstractTestCase
 *
 * @package Ixolit\Dislo\Test
 */
abstract class AbstractTestCase extends TestCase {

    /**
     * @param BillingMethod|null $billingMethod
     * @param BillingMethod|null $testBillingMethod
     *
     * @return $this
     */
    protected function compareBillingMethod(
        BillingMethod $billingMethod = null,
        BillingMethod $testBillingMethod = null
    ) {
        if ($this->compareNonObject($billingMethod, $testBillingMethod, BillingMethod::class)) {
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
     * @param Flexible|null $flexible
     * @param Flexible|null $testFlexible
     *
     * @return $this
     */
    protected function compareFlexible(
        Flexible $flexible = null,
        Flexible $testFlexible = null
    ) {
        if ($this->compareNonObject($flexible, $testFlexible, Flexible::class)) {
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
     * @param BillingEvent|null $billingEvent
     * @param BillingEvent|null $testBillingEvent
     *
     * @return $this
     */
    protected function compareBillingEvent(
        BillingEvent $billingEvent = null,
        BillingEvent $testBillingEvent = null
    ) {
        if ($this->compareNonObject($billingEvent, $testBillingEvent, BillingEvent::class)) {
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
     * @param Subscription|null $subscription
     * @param Subscription|null $testSubscription
     *
     * @return $this
     */
    protected function compareSubscription(
        Subscription $subscription = null,
        Subscription $testSubscription = null
    ) {
        if ($this->compareNonObject($subscription, $testSubscription, Subscription::class)) {
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
     * @param Package|null $package
     * @param Package|null $testPackage
     *
     * @return $this
     */
    protected function comparePackage(Package $package = null, Package $testPackage = null) {
        if ($this->compareNonObject($package, $testPackage, Package::class)) {
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
     * @param NextPackage|null $nextPackage
     * @param NextPackage|null $testNextPackage
     *
     * @return $this
     */
    protected function compareNextPackage(
        NextPackage $nextPackage = null,
        NextPackage $testNextPackage = null
    ) {
        if ($this->compareNonObject($nextPackage, $testNextPackage, NextPackage::class)) {
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
     * @param PackagePeriod|null $packagePeriod
     * @param PackagePeriod|null $testPackagePeriod
     *
     * @return $this
     */
    protected function comparePackagePeriod(
        PackagePeriod $packagePeriod = null,
        PackagePeriod $testPackagePeriod = null
    ) {
        if ($this->compareNonObject($packagePeriod, $testPackagePeriod, PackagePeriod::class)) {
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
     * @param Price|null $price
     * @param Price|null $testPrice
     *
     * @return $this
     */
    protected function comparePrice(Price $price = null, Price $testPrice = null) {
        if ($this->compareNonObject($price, $testPrice, Price::class)) {
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
     * @param CouponUsage|null $couponUsage
     * @param CouponUsage|null $testCouponUsage
     *
     * @return $this
     */
    protected function compareCouponUsage(
        CouponUsage $couponUsage = null,
        CouponUsage $testCouponUsage = null
    ) {
        if ($this->compareNonObject($couponUsage, $testCouponUsage, CouponUsage::class)) {
            return $this;
        }

        $this->compareCoupon($couponUsage->getCoupon(), $testCouponUsage->getCoupon());
        $this->assertEquals($couponUsage->getNumPeriods(), $testCouponUsage->getNumPeriods());
        $this->assertEquals($couponUsage->getCreatedAt(), $testCouponUsage->getCreatedAt());
        $this->assertEquals($couponUsage->getModifiedAt(), $testCouponUsage->getModifiedAt());

        return $this;
    }

    /**
     * @param Coupon|null $coupon
     * @param Coupon|null $testCoupon
     *
     * @return $this
     */
    protected function compareCoupon(Coupon $coupon = null, Coupon $testCoupon = null) {
        if ($this->compareNonObject($coupon, $testCoupon, Coupon::class)) {
            return $this;
        }

        $this->assertEquals($coupon->getCode(), $testCoupon->getCode());
        $this->assertEquals($coupon->getDescription(), $testCoupon->getDescription());

        return $this;
    }

    /**
     * @param PeriodEvent|null $periodEvent
     * @param PeriodEvent|null $testPeriodEvent
     *
     * @return $this
     */
    protected function comparePeriodEvent(
        PeriodEvent $periodEvent = null,
        PeriodEvent $testPeriodEvent = null
    ) {
        if ($this->compareNonObject($periodEvent, $testPeriodEvent, PeriodEvent::class)) {
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
     * @param DisplayName|null $displayName
     * @param DisplayName|null $testDisplayName
     *
     * @return $this
     */
    protected function compareDisplayName(
        DisplayName $displayName = null,
        DisplayName $testDisplayName = null
    ) {
        if ($this->compareNonObject($displayName, $testDisplayName, DisplayName::class)) {
            return $this;
        }

        $this->assertEquals($displayName->getLanguage(), $testDisplayName->getLanguage());
        $this->assertEquals($displayName->getName(), $testDisplayName->getName());

        return $this;
    }

    /**
     * @param ExternalProfile|null $externalProfile
     * @param ExternalProfile|null $testExternalProfile
     *
     * @return $this
     */
    protected function compareExternalProfile(
        ExternalProfile $externalProfile = null,
        ExternalProfile $testExternalProfile = null
    ) {
        if ($this->compareNonObject($externalProfile, $testExternalProfile, ExternalProfile::class)) {
            return $this;
        }

        $this->assertEquals($externalProfile->getUserId(), $testExternalProfile->getUserId());
        $this->assertEquals($externalProfile->getSubscriptionId(), $testExternalProfile->getSubscriptionId());
        $this->assertEmpty(\array_diff($externalProfile->getExtraData(), $testExternalProfile->getExtraData()));
        $this->assertEquals($externalProfile->getExternalId(), $testExternalProfile->getExternalId());

        return $this;
    }

    /**
     * @param Recurring|null $recurring
     * @param Recurring|null $testRecurring
     *
     * @return $this
     */
    protected function compareRecurring(Recurring $recurring = null, Recurring $testRecurring = null) {
        if ($this->compareNonObject($recurring, $testRecurring, Recurring::class)) {
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
     * @param User|null $user
     * @param User|null $testUser
     *
     * @return $this
     */
    protected function compareUser(User $user = null, User $testUser = null) {
        if ($this->compareNonObject($user, $testUser, User::class)) {
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
     * @param AuthToken|null $authToken
     * @param AuthToken|null $testAuthToken
     *
     * @return $this
     */
    protected function compareAuthToken(AuthToken $authToken = null, AuthToken $testAuthToken = null) {
        if ($this->compareNonObject($authToken, $testAuthToken, AuthToken::class)) {
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
     * @param MetaProfileElement|null $metaProfileElement
     * @param MetaProfileElement|null $testMetaProfileElement
     *
     * @return $this
     */
    protected function compareMetaProfileElement(
        MetaProfileElement $metaProfileElement = null,
        MetaProfileElement $testMetaProfileElement = null
    ) {
        if (
            $this->compareNonObject($metaProfileElement, $testMetaProfileElement, MetaProfileElement::class)
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
     * @return Client
     */
    protected function createFrontendClient($response = [], $forceTokenMode = true) {
        return new Client(
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