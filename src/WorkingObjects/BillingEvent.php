<?php

namespace Ixolit\Dislo\WorkingObjects;

class BillingEvent implements WorkingObject {
	const TYPE_AUTHORIZE = 'authorize';
	const TYPE_CHARGE = 'charge';
	const TYPE_REFUND = 'refund';
	const TYPE_CHARGEBACK = 'chargeback';

	const STATUS_REQUESTED = 'requested';
	const STATUS_SUCCESS = 'success';
	const STATUS_ERROR = 'error';

	/**
	 * @var int
	 */
	private $billingEventId;
	/**
	 * @var int
	 */
	private $userId;
	/**
	 * @var string
	 */
	private $currencyCode;
	/**
	 * @var float
	 */
	private $amount;
	/**
	 * @var \DateTime
	 */
	private $createdAt;
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var string
	 */
	private $status;
	/**
	 * @var string
	 */
	private $description;
	/**
	 * @var null|string
	 */
	private $techinfo;
	/**
	 * @var string
	 */
	private $billingMethod;
	/**
	 * @var Subscription|null
	 */
	private $subscription;

	/**
	 * @var \DateTime|null
	 */
	private $modifiedAt;

	/** @var BillingMethod */
	private $billingMethodObject;

	/** @var array */
	private $paymentDetails;

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		if (isset($response['subscription']) && $response['subscription']) {
			$subscription = Subscription::fromResponse($response['subscription']);
		} else {
			$subscription = null;
		}

		return new BillingEvent(
			$response['billingEventId'],
			$response['userId'],
			$response['currencyCode'],
			$response['amount'],
			new \DateTime($response['createdAt']),
			$response['type'],
			$response['status'],
			$response['description'],
			$response['techinfo'],
			$response['billingMethod'],
			$subscription,
			isset($response['modifiedAt']) ? new \DateTime($response['modifiedAt']) : null,
			isset($response['billingMethodObject']) ? BillingMethod::fromResponse($response['billingMethodObject']) : null,
			isset($response['paymentDetails']) ? $response['paymentDetails'] : []
		);
	}

	/**
	 * BillingEvent constructor.
	 *
	 * @param int               $billingEventId
	 * @param int               $userId
	 * @param string            $currencyCode
	 * @param float             $amount
	 * @param \DateTime         $createdAt
	 * @param string            $type
	 * @param string            $status
	 * @param string            $description
	 * @param string|null       $techinfo
	 * @param string            $billingMethod
	 * @param Subscription|null $subscription
	 * @param \DateTime|null    $modifiedAt
	 * @param BillingMethod|null $billingMethodObject
	 * @param array             $paymentDetails
	 */
	public function __construct(
		$billingEventId,
		$userId,
		$currencyCode,
		$amount,
		$createdAt,
		$type,
		$status,
		$description,
		$techinfo,
		$billingMethod,
		Subscription $subscription = null,
		$modifiedAt = null,
		$billingMethodObject = null,
		$paymentDetails = []
	) {
		$this->billingEventId = $billingEventId;
		$this->userId         = $userId;
		$this->currencyCode   = $currencyCode;
		$this->amount         = $amount;
		$this->createdAt      = $createdAt;
		$this->type           = $type;
		$this->status         = $status;
		$this->description    = $description;
		$this->techinfo       = $techinfo;
		$this->billingMethod  = $billingMethod;
		$this->subscription   = $subscription;
		$this->modifiedAt     = $modifiedAt;
		$this->billingMethodObject = $billingMethodObject;
		$this->paymentDetails = $paymentDetails;
	}

	/**
	 * @return int
	 */
	public function getBillingEventId() {
		return $this->billingEventId;
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
	public function getCurrencyCode() {
		return $this->currencyCode;
	}

	/**
	 * @return float
	 */
	public function getAmount() {
		return $this->amount;
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
	public function getType() {
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return null|string
	 */
	public function getTechinfo() {
		return $this->techinfo;
	}

	/**
	 * @return string
	 */
	public function getBillingMethod() {
		return $this->billingMethod;
	}

	/**
	 * @return Subscription|null
	 */
	public function getSubscription() {
		return $this->subscription;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getModifiedAt() {
		return $this->modifiedAt;
	}

	/**
	 * @return BillingMethod
	 */
	public function getBillingMethodObject() {
		return $this->billingMethodObject;
	}

	/**
	 * @return array
	 */
	public function getPaymentDetails() {
		return $this->paymentDetails;
	}

	/**
	 * @param string $name
	 * @param mixed $defaultValue
	 * @return mixed|null
	 */
	public function getPaymentDetailValue($name, $defaultValue = null) {
		$paymentDetails = $this->getPaymentDetails();
		return isset($paymentDetails[$name]) ? $paymentDetails[$name] : $defaultValue;
    }

	/**
	 * @return array
	 */
	public function toArray() {
		return array(
			'_type'          => 'BillingEvent',
			'billingEventId' => $this->getBillingEventId(),
			'userId'         => $this->getUserId(),
			'currencyCode'   => $this->currencyCode,
			'amount'         => $this->getAmount(),
			'createdAt'      => $this->getCreatedAt()->format('Y-m-d H:i:s'),
			'type'           => $this->getType(),
			'status'         => $this->getStatus(),
			'description'    => $this->getDescription(),
			'techinfo'       => $this->getDescription(),
			'billingMethod'  => $this->getBillingMethod(),
			'subscription'   => ($this->getSubscription() ? $this->getSubscription()->toArray() : null),
			'modifiedAt'	 => ($this->getModifiedAt() ? $this->getModifiedAt()->format('Y-m-d H:i:s') : null),
			'billingMethodObject' => ($this->getBillingMethodObject() ? $this->getBillingMethodObject()->toArray() : null),
			'paymentDetails' => $this->getPaymentDetails(),
		);
	}
}