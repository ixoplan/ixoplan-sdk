<?php

use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\AuthTokenMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\AuthToken;
use Ixolit\Dislo\WorkingObjects\User;
use Ixolit\Dislo\WorkingObjectsCustom\UserCustom;

/**
 * Class UserTest
 */
class UserTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $userId        = MockHelper::getFaker()->uuid;
        $createdAt     = MockHelper::getFaker()->dateTime();
        $loginDisabled = MockHelper::getFaker()->boolean();
        $language      = MockHelper::getFaker()->languageCode;
        $lastLoginDate = MockHelper::getFaker()->dateTime();
        $lastLoginIp   = MockHelper::getFaker()->ipv4;
        $metaData      = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $currencyCode  = MockHelper::getFaker()->currencyCode;
        $verifiedData  = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $authToken     = AuthTokenMock::create();

        $user = new User(
            $userId,
            $createdAt,
            $loginDisabled,
            $language,
            $lastLoginDate,
            $lastLoginIp,
            $metaData,
            $currencyCode,
            $verifiedData,
            $authToken
        );

        $reflectionObject = new \ReflectionObject($user);

        $userIdProperty = $reflectionObject->getProperty('userId');
        $userIdProperty->setAccessible(true);
        $this->assertEquals($userId, $userIdProperty->getValue($user));

        $createdAtProperty = $reflectionObject->getProperty('createdAt');
        $createdAtProperty->setAccessible(true);
        $this->assertEquals($createdAt, $createdAtProperty->getValue($user));

        $loginDisabledProperty = $reflectionObject->getProperty('loginDisabled');
        $loginDisabledProperty->setAccessible(true);
        $this->assertEquals($loginDisabled, $loginDisabledProperty->getValue($user));

        $languageProperty = $reflectionObject->getProperty('language');
        $languageProperty->setAccessible(true);
        $this->assertEquals($language, $languageProperty->getValue($user));

        $lastLoginDateProperty = $reflectionObject->getProperty('lastLoginDate');
        $lastLoginDateProperty->setAccessible(true);
        $this->assertEquals($lastLoginDate, $lastLoginDateProperty->getValue($user));

        $lastLoginIpProperty = $reflectionObject->getProperty('lastLoginIp');
        $lastLoginIpProperty->setAccessible(true);
        $this->assertEquals($lastLoginIp, $lastLoginIpProperty->getValue($user));

        $metaDataProperty = $reflectionObject->getProperty('metaData');
        $metaDataProperty->setAccessible(true);
        $this->assertEquals($metaData, $metaDataProperty->getValue($user));

        $currencyCodeProperty = $reflectionObject->getProperty('currencyCode');
        $currencyCodeProperty->setAccessible(true);
        $this->assertEquals($currencyCode, $currencyCodeProperty->getValue($user));

        $verifiedDataProperty = $reflectionObject->getProperty('verifiedData');
        $verifiedDataProperty->setAccessible(true);
        $this->assertEquals($verifiedData, $verifiedDataProperty->getValue($user));

        $authTokenProperty = $reflectionObject->getProperty('authToken');
        $authTokenProperty->setAccessible(true);
        $this->compareAuthToken($authTokenProperty->getValue($user), $authToken);

        new User(
            $userId,
            $createdAt,
            $loginDisabled,
            $language,
            $lastLoginDate,
            $lastLoginIp,
            $metaData
        );
    }

    /**
     * @return void
     */
    public function testGetters() {
        $userId        = MockHelper::getFaker()->uuid;
        $createdAt     = MockHelper::getFaker()->dateTime();
        $loginDisabled = MockHelper::getFaker()->boolean();
        $language      = MockHelper::getFaker()->languageCode;
        $lastLoginDate = MockHelper::getFaker()->dateTime();
        $lastLoginIp   = MockHelper::getFaker()->ipv4;

        $metaDataName  = MockHelper::getFaker()->uuid;
        $metaDataEntry = MockHelper::getFaker()->word;
        $metaData      = [
            $metaDataName => $metaDataEntry,
        ];
        $currencyCode  = MockHelper::getFaker()->currencyCode;
        $verifiedData  = [
            'email',
        ];
        $authToken     = AuthTokenMock::create();

        $user = new User(
            $userId,
            $createdAt,
            $loginDisabled,
            $language,
            $lastLoginDate,
            $lastLoginIp,
            $metaData,
            $currencyCode,
            $verifiedData,
            $authToken
        );

        $this->assertEquals($userId, $user->getUserId());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals($loginDisabled, $user->isLoginDisabled());
        $this->assertEquals($language, $user->getLanguage());
        $this->assertEquals($lastLoginDate, $user->getLastLoginDate());
        $this->assertEquals($lastLoginIp, $user->getLastLoginIp());
        $this->assertEquals($metaData, $user->getMetaData());
        $this->assertEquals($currencyCode, $user->getCurrencyCode());
        $this->assertEquals($verifiedData, $user->getVerifiedData());
        $this->compareAuthToken($user->getAuthToken(), $authToken);

        $newAuthToken = AuthTokenMock::create();
        $user->setAuthToken($newAuthToken);
        $this->compareAuthToken($user->getAuthToken(), $newAuthToken);

        $this->assertEquals($metaDataEntry, $user->getMetaDataEntry($metaDataName));


        $this->assertEquals(\in_array('email', $verifiedData), $user->isEmailVerified());

        $verifiedData = [
            MockHelper::getFaker()->uuid,
        ];

        $user = new User(
            $userId,
            $createdAt,
            $loginDisabled,
            $language,
            $lastLoginDate,
            $lastLoginIp,
            $metaData,
            $currencyCode,
            $verifiedData,
            $authToken
        );

        $this->assertEquals(\in_array('email', $verifiedData), $user->isEmailVerified());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $createdAt     = MockHelper::getFaker()->dateTime();
        $lastLoginDate = MockHelper::getFaker()->dateTime();
        $authToken     = AuthTokenMock::create();

        $response = [
            'userId'        => MockHelper::getFaker()->uuid,
            'createdAt'     => $createdAt->format('Y-m-d H:i:s'),
            'loginDisabled' => MockHelper::getFaker()->boolean(),
            'verifiedData'  => [
                MockHelper::getFaker()->uuid,
            ],
            'language'      => MockHelper::getFaker()->languageCode,
            'currencyCode'  => MockHelper::getFaker()->currencyCode,
            'lastLoginDate' => $lastLoginDate->format('Y-m-d H:i:s'),
            'lastLoginIp'   => MockHelper::getFaker()->ipv4,
            'metaData'      => [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            'authToken'     => $authToken->toArray(),
        ];

        $user = User::fromResponse($response);

        $this->assertEquals($response['userId'], $user->getUserId());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals($response['loginDisabled'], $user->isLoginDisabled());
        $this->assertEquals($response['verifiedData'], $user->getVerifiedData());
        $this->assertEquals($response['language'], $user->getLanguage());
        $this->assertEquals($response['currencyCode'], $user->getCurrencyCode());
        $this->assertEquals($lastLoginDate, $user->getLastLoginDate());
        $this->assertEquals($response['lastLoginIp'], $user->getLastLoginIp());
        $this->assertEquals($response['metaData'], $user->getMetaData());
        $this->compareAuthToken($user->getAuthToken(), $authToken);
    }

    /**
     * @return void
     */
    public function testToArray() {
        $createdAt     = MockHelper::getFaker()->dateTime();
        $lastLoginDate = MockHelper::getFaker()->dateTime();
        $authToken     = AuthTokenMock::create();

        $user = new User(
            MockHelper::getFaker()->uuid,
            $createdAt,
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->languageCode,
            $lastLoginDate,
            MockHelper::getFaker()->ipv4,
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->currencyCode,
            [
                MockHelper::getFaker()->uuid,
            ],
            $authToken
        );

        $userArray = $user->toArray();

        $this->assertEquals($user->getUserId(), $userArray['userId']);
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $userArray['createdAt']);
        $this->assertEquals($user->isLoginDisabled(), $userArray['loginDisabled']);
        $this->assertEquals($user->getLanguage(), $userArray['language']);
        $this->assertEquals($lastLoginDate->format('Y-m-d H:i:s'), $userArray['lastLoginDate']);
        $this->assertEquals($user->getLastLoginIp(), $userArray['lastLoginIp']);
        $this->assertEquals($user->getMetaData(), $userArray['metaData']);
        $this->assertEquals($user->getCurrencyCode(), $userArray['currencyCode']);
        $this->assertEquals($user->getVerifiedData(), $userArray['verifiedData']);
        $this->compareAuthToken(AuthToken::fromResponse($userArray['authToken']), $authToken);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $user = new User(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->languageCode,
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->ipv4,
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->currencyCode,
            [
                MockHelper::getFaker()->uuid,
            ],
            AuthTokenMock::create()
        );

        $userCustomObject = $user->getCustom();

        $this->assertInstanceOf(UserCustom::class, $userCustomObject);
    }

}