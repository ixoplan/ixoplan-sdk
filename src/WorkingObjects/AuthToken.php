<?php

namespace Ixolit\Dislo\WorkingObjects;

class AuthToken implements WorkingObject {
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var \DateTime
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 */
	private $modifiedAt;

	/**
	 * @var \DateTime
	 */
	private $validUntil;

	/**
	 * @var string
	 */
	private $metaInfo;

	/**
	 * @param int       $id
	 * @param int       $userId
	 * @param string    $token
	 * @param \DateTime $createdAt
	 * @param \DateTime $modifiedAt
	 * @param \DateTime $validUntil
	 * @param string    $metaInfo
	 */
	public function __construct(
		$id,
		$userId,
		$token,
		\DateTime $createdAt,
		\DateTime $modifiedAt,
		\DateTime $validUntil,
		$metaInfo
	) {
		$this->id         = $id;
		$this->userId     = $userId;
		$this->token      = $token;
		$this->createdAt  = $createdAt;
		$this->modifiedAt = $modifiedAt;
		$this->validUntil = $validUntil;
		$this->metaInfo   = $metaInfo;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return int
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @return string
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * @return \DateTime
	 */
	public function getModifiedAt() {
		return $this->modifiedAt;
	}

	/**
	 * @return \DateTime
	 */
	public function getValidUntil() {
		return $this->validUntil;
	}

	/**
	 * @return string
	 */
	public function getMetaInfo() {
		return $this->metaInfo;
	}

	public static function fromResponse($response) {
		return new AuthToken(
			$response['id'],
			$response['userId'],
			$response['loginToken'],
			new \DateTime($response['createdAt']),
			new \DateTime($response['modifiedAt']),
			new \DateTime($response['validUntil']),
			$response['metaInfo']
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
			'id' => $this->getId(),
			'userId' => $this->getUserId(),
			'loginToken' => $this->getToken(),
			'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
			'modifiedAt' => $this->getModifiedAt()->format('Y-m-d H:i:s'),
			'validUntil' => $this->getValidUntil()->format('Y-m-d H:i:s'),
			'metaInfo' => $this->getMetaInfo()
		];
	}
}