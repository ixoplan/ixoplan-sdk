<?php

namespace Ixolit\Dislo\WorkingObjects;

class Subscription implements WorkingObject {

	const STATUS_PENDING = 'pending';
	const STATUS_RUNNING = 'running';
	const STATUS_CANCELED = 'canceled';
	const STATUS_CLOSED = 'closed';
	const STATUS_ARCHIVED = 'archived';
	const STATUS_SUSPENDED_RUNNING = 'suspended_running';
	const STATUS_SUSPENDED_CANCELED = 'suspended_canceled';

	/**
	 * @var int
	 */
	private $subscriptionId;
	/**
	 * @var Package
	 */
	private $currentPackage;
	/**
	 * @var int
	 */
	private $userId;
	/**
	 * @var string
	 */
	private $status;
	/**
	 * @var \DateTime
	 */
	private $startedAt;
	/**
	 * @var \DateTime|null
	 */
	private $canceledAt;
	/**
	 * @var \DateTime|null
	 */
	private $closedAt;
	/**
	 * @var \DateTime|null
	 */
	private $expiresAt;
	/**
	 * @var \DateTime|null
	 */
	private $nextBillingAt;
	/**
	 * @var string
	 */
	private $currencyCode;
	/**
	 * @var bool
	 */
	private $isInitialPeriod;
	/**
	 * @var bool
	 */
	private $isProvisioned;
	/**
	 * @var array
	 */
	private $provisioningMetaData;
	/**
	 * @var Package|null
	 */
	private $nextPackage;
	/**
	 * @var Subscription[]
	 */
	private $addonSubscriptions = [];

	/** @var \DateTime|null */
	private $minimumTermEndsAt;

	/**
	 * Subscription constructor.
	 *
	 * @param int            $subscriptionId
	 * @param Package        $currentPackage
	 * @param int            $userId
	 * @param string         $status
	 * @param \DateTime|null $startedAt
	 * @param \DateTime|null $canceledAt
	 * @param \DateTime|null $closedAt
	 * @param \DateTime|null $expiresAt
	 * @param \DateTime|null $nextBillingAt
	 * @param string         $currencyCode
	 * @param bool           $isInitialPeriod
	 * @param bool           $isProvisioned
	 * @param array          $provisioningMetaData
	 * @param Package|null   $nextPackage
	 * @param Subscription[] $addonSubscriptions
	 * @param \DateTime|null $minimumTermEndsAt
	 */
	public function __construct(
		$subscriptionId, Package $currentPackage, $userId, $status, $startedAt,
		$canceledAt, $closedAt, $expiresAt, $nextBillingAt, $currencyCode, $isInitialPeriod,
		$isProvisioned, $provisioningMetaData, $nextPackage, $addonSubscriptions, $minimumTermEndsAt = null) {
		$this->subscriptionId       = $subscriptionId;
		$this->currentPackage       = $currentPackage;
		$this->userId               = $userId;
		$this->status               = $status;
		$this->startedAt            = $startedAt;
		$this->canceledAt           = $canceledAt;
		$this->closedAt             = $closedAt;
		$this->expiresAt            = $expiresAt;
		$this->nextBillingAt        = $nextBillingAt;
		$this->currencyCode         = $currencyCode;
		$this->isInitialPeriod      = $isInitialPeriod;
		$this->isProvisioned        = $isProvisioned;
		$this->provisioningMetaData = $provisioningMetaData;
		$this->nextPackage          = $nextPackage;
		$this->addonSubscriptions   = $addonSubscriptions;
		$this->minimumTermEndsAt    = $minimumTermEndsAt;
	}

	/**
	 * @return int
	 */
	public function getSubscriptionId() {
		return $this->subscriptionId;
	}

	/**
	 * @return Package
	 */
	public function getCurrentPackage() {
		return $this->currentPackage;
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
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return \DateTime
	 */
	public function getStartedAt() {
		return $this->startedAt;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getCanceledAt() {
		return $this->canceledAt;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getClosedAt() {
		return $this->closedAt;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getExpiresAt() {
		return $this->expiresAt;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getNextBillingAt() {
		return $this->nextBillingAt;
	}

	/**
	 * @return string
	 */
	public function getCurrencyCode() {
		return $this->currencyCode;
	}

	/**
	 * @return boolean
	 */
	public function isInitialPeriod() {
		return $this->isInitialPeriod;
	}

	/**
	 * @return boolean
	 */
	public function isIsProvisioned() {
		return $this->isProvisioned();
	}

	/**
	 * @return boolean
	 */
	public function isProvisioned() {
		//todo workaround for API problem
		return !empty($this->getProvisioningMetaData());
		//return $this->isProvisioned;
	}

	/**
	 * @return array
	 */
	public function getProvisioningMetaData() {
		return $this->provisioningMetaData;
	}

	/**
	 * @param string $metaDataName
	 *
	 * @return string|null
	 */
	public function getProvisioningMetaDataEntry($metaDataName) {
		$provisioningMetaData = $this->getProvisioningMetaData();

		return isset($provisioningMetaData[$metaDataName]) ? $provisioningMetaData[$metaDataName] : null;
	}

	/**
	 * @return Package|null
	 */
	public function getNextPackage() {
		return $this->nextPackage;
	}

	/**
	 * @return Subscription[]
	 */
	public function getAddonSubscriptions() {
		return $this->addonSubscriptions;
	}

	public function getMinimumTermEndsAt() {
		return $this->minimumTermEndsAt;
	}

	/**
	 * @return PackagePeriod
	 */
	public function getCurrentPeriod() {
		if ($this->isInitialPeriod()) {
			return $this->getCurrentPackage()->getInitialPeriod();
		} else {
			return $this->getCurrentPackage()->getRecurringPeriod();
		}
	}

	/**
	 * @return bool
	 */
	public function isInPaidPeriod() {
		if (!$this->isActive()) {
			return false;
		}
		return $this->getCurrentPeriod()->isPaid();
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		$addonSubscriptions = [];
		foreach ($response['addonSubscriptions'] as $addonSubscription) {
			$addonSubscriptions[] = Subscription::fromResponse($addonSubscription);
		}
		return new Subscription(
			$response['subscriptionId'],
			Package::fromResponse($response['currentPackage']),
			$response['userId'],
			$response['status'],
			($response['startedAt']?new \DateTime($response['startedAt']):null),
			($response['canceledAt']?new \DateTime($response['canceledAt']):null),
			($response['closedAt']?new \DateTime($response['closedAt']):null),
			($response['expiresAt']?new \DateTime($response['expiresAt']):null),
			($response['nextBillingAt']?new \DateTime($response['nextBillingAt']):null),
			$response['currencyCode'],
			$response['isInitialPeriod'],
			$response['isProvisioned'],
			$response['provisioningMetaData'],
			($response['nextPackage']?Package::fromResponse($response['nextPackage']):null),
			$addonSubscriptions,
			(isset($response['minimumTermEndsAt']) ? new \DateTime($response['minimumTermEndsAt']) : null)
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$addonSubscriptions = [];
		foreach ($this->addonSubscriptions as $addonSubscription) {
			$addonSubscriptions[] = $addonSubscription->toArray();
		}
		return [
			'subscriptionId' => $this->subscriptionId,
			'currentPackage' => ($this->currentPackage?$this->currentPackage->toArray():null),
			'userId' => $this->userId,
			'status' => $this->status,
			'startedAt' => ($this->startedAt?$this->startedAt->format('Y-m-d H:i:s'):null),
			'canceledAt' => ($this->canceledAt?$this->canceledAt->format('Y-m-d H:i:s'):null),
			'closedAt' => ($this->closedAt?$this->closedAt->format('Y-m-d H:i:s'):null),
			'expiresAt' => ($this->expiresAt?$this->expiresAt->format('Y-m-d H:i:s'):null),
			'nextBillingAt' => ($this->nextBillingAt?$this->nextBillingAt->format('Y-m-d H:i:s'):null),
			'currencyCode' => $this->currencyCode,
			'isInitialPeriod' => $this->isInitialPeriod,
			'isProvisioned' => $this->isProvisioned,
			'provisioningMetaData' => $this->provisioningMetaData,
			'nextPackage' => ($this->nextPackage?$this->nextPackage->toArray():null),
			'addonSubscriptions' => $addonSubscriptions,
			'minimumTermEndsAt' => ($this->minimumTermEndsAt ? $this->minimumTermEndsAt->format('Y-m-d H:i:s') : null),
		];
	}

	public function isActive() {
		return \in_array($this->getStatus(), [
			self::STATUS_RUNNING,
			self::STATUS_CANCELED
		]);
	}
}