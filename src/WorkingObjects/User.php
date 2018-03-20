<?php

namespace Ixolit\Dislo\WorkingObjects;


use Ixolit\Dislo\WorkingObjectsCustom\User\UserCustom;

/**
 * Class User
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class User extends AbstractWorkingObject {

	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var \DateTime
	 */
	private $createdAt;

	/**
	 * @var bool
	 */
	private $loginDisabled;

	/**
	 * @var string
	 */
	private $language;

	/**
	 * @var \DateTime|null
	 */
	private $lastLoginDate;

	/**
	 * @var string
	 */
	private $lastLoginIp;

	/**
	 * @var array
	 */
	private $metaData;

	/**
	 * @var string|null
	 */
	private $currencyCode;

	/**
	 * @var array
	 */
	private $verifiedData = [];

    /**
     * @var AuthToken
     */
	private $authToken;

    /**
     * @param int            $userId
     * @param \DateTime      $createdAt
     * @param bool           $loginDisabled
     * @param string         $language
     * @param \DateTime      $lastLoginDate
     * @param string         $lastLoginIp
     * @param array          $metaData
     * @param string|null    $currencyCode
     * @param string[]       $verifiedData
     * @param AuthToken|null $authToken
     */
	public function __construct(
        $userId,
        $createdAt,
        $loginDisabled,
        $language,
        $lastLoginDate,
        $lastLoginIp,
        $metaData,
        $currencyCode = null,
        $verifiedData = [],
        AuthToken $authToken = null
    ) {
		$this->userId        = $userId;
		$this->createdAt     = $createdAt;
		$this->loginDisabled = $loginDisabled;
		$this->language      = $language;
		$this->lastLoginDate = $lastLoginDate;
		$this->lastLoginIp   = $lastLoginIp;
		$this->metaData      = $metaData;
		$this->currencyCode  = $currencyCode;
		$this->verifiedData  = $verifiedData;
		$this->authToken     = $authToken;

		$this->addCustomObject();
	}

    /**
     * @return UserCustom|null
     */
    public function getCustom() {
        /** @var UserCustom $custom */
        $custom = ($this->getCustomObject() instanceof UserCustom)
            ? $this->getCustomObject()
            : null;

        return $custom;
    }

	/**
	 * @return int
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * @return boolean
	 */
	public function isLoginDisabled() {
		return $this->loginDisabled;
	}

	/**
	 * @return string
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * @return \DateTime
	 */
	public function getLastLoginDate() {
		return $this->lastLoginDate;
	}

	/**
	 * @return string
	 */
	public function getLastLoginIp() {
		return $this->lastLoginIp;
	}

	/**
	 * @return array
	 */
	public function getMetaData() {
		return $this->metaData;
	}

	/**
	 * @param string $metaDataName
	 *
	 * @return string|null
	 */
	public function getMetaDataEntry($metaDataName) {
		$metaData = $this->getMetaData();

		return isset($metaData[$metaDataName]) ? $metaData[$metaDataName] : null;
	}

	/**
	 * @return null|string
	 */
	public function getCurrencyCode() {
		return $this->currencyCode;
	}

	/**
	 * @return string[]
	 */
	public function getVerifiedData() {
		return $this->verifiedData;
	}

	/**
	 * @return bool
	 */
	public function isEmailVerified() {
		return in_array('email', $this->verifiedData);
	}

    /**
     * @return AuthToken|null
     */
	public function getAuthToken() {
	    return $this->authToken;
    }

    /**
     * @param AuthToken $authToken
     * @return $this
     */
    public function setAuthToken(AuthToken $authToken){
        $this->authToken = $authToken;
        return $this;
    }

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
        return new self(
            static::getValueIsSet($response, 'userId'),
            static::getValueAsDateTime($response, 'createdAt'),
            static::getValueIsSet($response, 'loginDisabled'),
            static::getValueIsSet($response, 'language'),
            static::getValueAsDateTime($response, 'lastLoginDate'),
            static::getValueIsSet($response, 'lastLoginIp'),
            static::getValueIsSet($response, 'metaData'),
            static::getValueIsSet($response, 'currencyCode'),
            static::getValueIsSet($response, 'verifiedData'),
            static::getValueIsSet($response, 'authToken', null, function ($value) {
                return AuthToken::fromResponse($value);
            })
        );
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
			'_type'         => 'User',
            'createdAt'     => $this->createdAt->format('Y-m-d H:i:s'),
            'loginDisabled' => $this->loginDisabled,
            'language'      => $this->language,
            'lastLoginDate' => ($this->lastLoginDate ? $this->lastLoginDate->format('Y-m-d H:i:s') : null),
            'lastLoginIp'   => $this->lastLoginIp,
            'metaData'      => $this->metaData,
            'currencyCode'  => $this->currencyCode,
            'verifiedData'  => $this->verifiedData,
            'authToken'     => ($this->authToken ? $this->authToken->toArray() : null),
		];
	}
}