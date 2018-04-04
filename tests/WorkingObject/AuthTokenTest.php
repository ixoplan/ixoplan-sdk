<?php

use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\AuthToken;
use Ixolit\Dislo\WorkingObjectsCustom\AuthTokenCustom;

/**
 * Class AuthTokenTest
 */
class AuthTokenTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $id = MockHelper::getFaker()->uuid;
        $userId = MockHelper::getFaker()->uuid;
        $token = MockHelper::getFaker()->uuid;
        $createdAt = MockHelper::getFaker()->dateTime();
        $modifiedAt = MockHelper::getFaker()->dateTime();
        $validUntil = MockHelper::getFaker()->dateTime();
        $metaInfo = MockHelper::getFaker()->word;

        $authToken = new AuthToken(
            $id,
            $userId,
            $token,
            $createdAt,
            $modifiedAt,
            $validUntil,
            $metaInfo
        );

        $reflectionObject = new \ReflectionObject($authToken);

        $idProperty = $reflectionObject->getProperty('id');
        $idProperty->setAccessible(true);
        $this->assertEquals($id, $idProperty->getValue($authToken));

        $userIdProperty = $reflectionObject->getProperty('userId');
        $userIdProperty->setAccessible(true);
        $this->assertEquals($userId, $userIdProperty->getValue($authToken));

        $tokenProperty = $reflectionObject->getProperty('token');
        $tokenProperty->setAccessible(true);
        $this->assertEquals($token, $tokenProperty->getValue($authToken));

        $createdAtProperty = $reflectionObject->getProperty('createdAt');
        $createdAtProperty->setAccessible(true);
        $this->assertEquals($createdAt, $createdAtProperty->getValue($authToken));

        $modifiedAtProperty = $reflectionObject->getProperty('modifiedAt');
        $modifiedAtProperty->setAccessible(true);
        $this->assertEquals($modifiedAt, $modifiedAtProperty->getValue($authToken));

        $validUntilProperty = $reflectionObject->getProperty('validUntil');
        $validUntilProperty->setAccessible(true);
        $this->assertEquals($validUntil, $validUntilProperty->getValue($authToken));

        $metaInfoProperty = $reflectionObject->getProperty('metaInfo');
        $metaInfoProperty->setAccessible(true);
        $this->assertEquals($metaInfo, $metaInfoProperty->getValue($authToken));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $id = MockHelper::getFaker()->uuid;
        $userId = MockHelper::getFaker()->uuid;
        $token = MockHelper::getFaker()->uuid;
        $createdAt = MockHelper::getFaker()->dateTime();
        $modifiedAt = MockHelper::getFaker()->dateTime();
        $validUntil = MockHelper::getFaker()->dateTime();
        $metaInfo = MockHelper::getFaker()->word;

        $authToken = new AuthToken(
            $id,
            $userId,
            $token,
            $createdAt,
            $modifiedAt,
            $validUntil,
            $metaInfo
        );

        $this->assertEquals($id, $authToken->getId());
        $this->assertEquals($userId, $authToken->getUserId());
        $this->assertEquals($token, $authToken->getToken());
        $this->assertEquals($createdAt, $authToken->getCreatedAt());
        $this->assertEquals($modifiedAt, $authToken->getModifiedAt());
        $this->assertEquals($validUntil, $authToken->getValidUntil());
        $this->assertEquals($metaInfo, $authToken->getMetaInfo());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $createdAt = MockHelper::getFaker()->dateTime();
        $modifiedAt = MockHelper::getFaker()->dateTime();
        $validUntil = MockHelper::getFaker()->dateTime();

        $response = [
            'id' => MockHelper::getFaker()->uuid,
            'userId' => MockHelper::getFaker()->uuid,
            'loginToken' => MockHelper::getFaker()->uuid,
            'modifiedAt' => $modifiedAt->format('Y-m-d H:i:s'),
            'createdAt' => $createdAt->format('Y-m-d H:i:s'),
            'validUntil' => $validUntil->format('Y-m-d H:i:s'),
            'metaInfo' => MockHelper::getFaker()->word,
        ];

        $authToken = AuthToken::fromResponse($response);

        $this->assertEquals($response['id'], $authToken->getId());
        $this->assertEquals($response['userId'], $authToken->getUserId());
        $this->assertEquals($response['loginToken'], $authToken->getToken());
        $this->assertEquals($createdAt, $authToken->getCreatedAt());
        $this->assertEquals($modifiedAt, $authToken->getModifiedAt());
        $this->assertEquals($validUntil, $authToken->getValidUntil());
        $this->assertEquals($response['metaInfo'], $authToken->getMetaInfo());
    }

    /**
     * @return void
     */
    public function testToArray() {
        $id = MockHelper::getFaker()->uuid;
        $userId = MockHelper::getFaker()->uuid;
        $token = MockHelper::getFaker()->uuid;
        $createdAt = MockHelper::getFaker()->dateTime();
        $modifiedAt = MockHelper::getFaker()->dateTime();
        $validUntil = MockHelper::getFaker()->dateTime();
        $metaInfo = MockHelper::getFaker()->word;

        $authToken = new AuthToken(
            $id,
            $userId,
            $token,
            $createdAt,
            $modifiedAt,
            $validUntil,
            $metaInfo
        );

        $authTokenArray = $authToken->toArray();

        $this->assertEquals($id, $authTokenArray['id']);
        $this->assertEquals($userId, $authTokenArray['userId']);
        $this->assertEquals($token, $authTokenArray['loginToken']);
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $authTokenArray['createdAt']);
        $this->assertEquals($modifiedAt->format('Y-m-d H:i:s'), $authTokenArray['modifiedAt']);
        $this->assertEquals($validUntil->format('Y-m-d H:i:s'), $authTokenArray['validUntil']);
        $this->assertEquals($metaInfo, $authTokenArray['metaInfo']);
    }

    /**
     * @return void
     */
    public function testToString() {
        $token = MockHelper::getFaker()->uuid;

        $authToken = new AuthToken(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            $token,
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->word
        );

        $this->assertEquals($token, (string)$authToken);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $authToken = new AuthToken(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->word
        );

        $authTokenCustom = $authToken->getCustom();

        $this->assertInstanceOf(AuthTokenCustom::class, $authTokenCustom);
    }

}