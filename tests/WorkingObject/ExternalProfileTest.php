<?php
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\ExternalProfile;
use Ixolit\Dislo\WorkingObjectsCustom\ExternalProfileCustom;

/**
 * Class ExternalProfileTest
 */
class ExternalProfileTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstruct() {
        $userId         = MockHelper::getFaker()->uuid;
        $subscriptionId = MockHelper::getFaker()->uuid;
        $extraData      = [
            MockHelper::getFaker()->uuid,
        ];
        $externalId     = MockHelper::getFaker()->uuid;

        $externalProfile = new ExternalProfile(
            $userId,
            $subscriptionId,
            $extraData,
            $externalId
        );

        $reflectionObject = new \ReflectionObject($externalProfile);

        $userIdProperty = $reflectionObject->getProperty('userId');
        $userIdProperty->setAccessible(true);
        $this->assertEquals($userId, $userIdProperty->getValue($externalProfile));

        $subscriptionIdProperty = $reflectionObject->getProperty('subscriptionId');
        $subscriptionIdProperty->setAccessible(true);
        $this->assertEquals($subscriptionId, $subscriptionIdProperty->getValue($externalProfile));

        $extraDataProperty = $reflectionObject->getProperty('extraData');
        $extraDataProperty->setAccessible(true);
        $this->assertEquals($extraData, $extraDataProperty->getValue($externalProfile));

        $externalIdProperty = $reflectionObject->getProperty('externalId');
        $externalIdProperty->setAccessible(true);
        $this->assertEquals($externalId, $externalIdProperty->getValue($externalProfile));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $userId         = MockHelper::getFaker()->uuid;
        $subscriptionId = MockHelper::getFaker()->uuid;
        $extraData      = [
            MockHelper::getFaker()->uuid,
        ];
        $externalId     = MockHelper::getFaker()->uuid;

        $externalProfile = new ExternalProfile(
            $userId,
            $subscriptionId,
            $extraData,
            $externalId
        );

        $this->assertEquals($userId, $externalProfile->getUserId());
        $this->assertEquals($subscriptionId, $externalProfile->getSubscriptionId());
        $this->assertEquals($extraData, $externalProfile->getExtraData());
        $this->assertEquals($externalId, $externalProfile->getExternalId());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $response = [
            'userId'         => MockHelper::getFaker()->uuid,
            'subscriptionId' => MockHelper::getFaker(),
            'extraData'      => [
                MockHelper::getFaker()->uuid,
            ],
            'externalId'     => MockHelper::getFaker(),
        ];

        $externapProfile = ExternalProfile::fromResponse($response);

        $this->assertEquals($response['userId'], $externapProfile->getUserId());
        $this->assertEquals($response['subscriptionId'], $externapProfile->getSubscriptionId());
        $this->assertEquals($response['extraData'], $externapProfile->getExtraData());
        $this->assertEquals($response['externalId'], $externapProfile->getExternalId());
    }

    /**
     * @return void
     */
    public function testToArray() {
        $externalProfile = new ExternalProfile(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            [
                MockHelper::getFaker()->uuid
            ],
            MockHelper::getFaker()->uuid
        );

        $externalProfileArray = $externalProfile->toArray();

        $this->assertEquals($externalProfile->getUserId(), $externalProfileArray['userId']);
        $this->assertEquals($externalProfile->getSubscriptionId(), $externalProfileArray['subscriptionId']);
        $this->assertEquals($externalProfile->getExtraData(), $externalProfileArray['extraData']);
        $this->assertEquals($externalProfile->getExternalId(), $externalProfileArray['externalId']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $externalProfile = new ExternalProfile(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            [
                MockHelper::getFaker()->uuid
            ],
            MockHelper::getFaker()->uuid
        );

        $externalProfileCustomObject = $externalProfile->getCustom();

        $this->assertInstanceOf(ExternalProfileCustom::class, $externalProfileCustomObject);
    }

}