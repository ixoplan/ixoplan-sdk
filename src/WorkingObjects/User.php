<?php

namespace Ixolit\Dislo\WorkingObjects;

class User implements WorkingObject {
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
	 * User constructor.
	 *
	 * @param int $userId
	 * @param \DateTime $createdAt
	 * @param bool $loginDisabled
	 * @param string $language
	 * @param \DateTime $lastLoginDate
	 * @param string $lastLoginIp
	 * @param array $metaData
	 */
	public function __construct($userId, $createdAt, $loginDisabled, $language, $lastLoginDate, $lastLoginIp,
								$metaData) {
		$this->userId        = $userId;
		$this->createdAt     = $createdAt;
		$this->loginDisabled = $loginDisabled;
		$this->language      = $language;
		$this->lastLoginDate = $lastLoginDate;
		$this->lastLoginIp   = $lastLoginIp;
		$this->metaData      = $metaData;
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
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse(array $response) {
		return new User(
			$response['userId'],
			new \DateTime($response['createdAt']),
			$response['loginDisabled'],
			$response['language'],
			($response['lastLoginDate']?new \DateTime($response['lastLoginDate']):null),
			$response['lastLoginIp'],
			$response['metaData']
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
			'_type' => 'User',
			'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
			'loginDisabled' => $this->loginDisabled,
			'language' => $this->language,
			'lastLoginDate' => ($this->lastLoginDate?$this->lastLoginDate->format('Y-m-d H:i:s'):null),
			'lastLoginIp' => $this->lastLoginIp,
			'metaData' => $this->metaData
		];
	}
}