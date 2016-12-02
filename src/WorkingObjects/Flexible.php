<?php

namespace Ixolit\Dislo\WorkingObjects;

class Flexible implements WorkingObject {

	const STATUS_ACTIVE = 'active';
	const STATUS_CLOSED = 'closed';
	const STATUS_PENDING = 'pending';

	/**
	 * @var int
	 */
	private $flexibleId;
	/**
	 * @var string
	 */
	private $status;

	/**
	 * @var string[]
	 */
	private $metaData = [];

	/**
	 * @var \DateTime
	 */
	private $createdAt;

	/**
	 * @var string
	 */
	private $billingMethod;

	/**
	 * @param int       $flexibleId
	 * @param string    $status
	 * @param string[]  $metaData
	 * @param \DateTime $createdAt
	 * @param string    $billingMethod
	 */
	public function __construct(
		$flexibleId,
		$status,
		$metaData,
		\DateTime $createdAt,
		$billingMethod
	) {
		$this->flexibleId    = $flexibleId;
		$this->status        = $status;
		$this->metaData      = $metaData;
		$this->createdAt     = $createdAt;
		$this->billingMethod = $billingMethod;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return new Flexible(
			$response['flexibleId'],
			$response['status'],
			$response['metaData'],
			new \DateTime($response['createdAt']),
			$response['billingMethod']
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
			'_type'         => 'Flexible',
			'flexibleId'    => $this->getFlexibleId(),
			'status'        => $this->getStatus(),
			'metaData'      => $this->getMetaData(),
			'createdAt'     => $this->getCreatedAt()->format('Y-m-d H:i:s'),
			'billingMethod' => $this->getBillingMethod(),
		];
	}

	/**
	 * @return int
	 */
	public function getFlexibleId() {
		return $this->flexibleId;
	}

	/**
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return \string[]
	 */
	public function getMetaData() {
		return $this->metaData;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * @return string
	 */
	public function getBillingMethod() {
		return $this->billingMethod;
	}
}