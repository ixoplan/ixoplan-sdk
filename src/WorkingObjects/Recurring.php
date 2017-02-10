<?php

namespace Ixolit\Dislo\WorkingObjects;

class Recurring implements WorkingObject {

	const STATUS_ACTIVE = 'active';
	const STATUS_CANCELED = 'canceled';
	const STATUS_CLOSED = 'closed';
	const STATUS_PENDING = 'pending';

	/**
	 * @var int
	 */
	private $recurringId;

	/**
	 * @var string
	 */
	private $status;

	/**
	 * @var string
	 */
	private $providerToken;

	/**
	 * @var Subscription
	 */
	private $subscription;

	/**
	 * @var \DateTime
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 */
	private $canceledAt;

	/**
	 * @var \DateTime
	 */
	private $closedAt;

	/**
	 * @var string[]
	 */
	private $parameters = [];

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
	 * @var BillingMethod
	 */
	private $billingMethod;

    /**
     * @param int            $recurringId
     * @param string         $status
     * @param string         $providerToken
     * @param Subscription   $subscription
     * @param \DateTime      $createdAt
     * @param \DateTime|null $canceledAt
     * @param \DateTime|null $closedAt
     * @param string[]       $parameters
     * @param float          $amount
     * @param string         $currency
     * @param BillingMethod  $billingMethod
     */
    public function __construct(
        $recurringId,
        $status,
        $providerToken,
        Subscription $subscription,
        \DateTime $createdAt,
        $canceledAt,
        $closedAt,
        $parameters,
        $amount,
        $currency,
        BillingMethod $billingMethod
    ) {
        $this->recurringId   = $recurringId;
        $this->status        = $status;
        $this->providerToken = $providerToken;
        $this->subscription  = $subscription;
        $this->createdAt     = $createdAt;
        $this->canceledAt    = $canceledAt;
        $this->closedAt      = $closedAt;
        $this->parameters    = $parameters;
        $this->amount        = $amount;
        $this->currency      = $currency;
        $this->billingMethod = $billingMethod;
    }

    /**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return new Recurring(
			$response['recurringId'],
			$response['status'],
			$response['providerToken'],
			Subscription::fromResponse($response['subscription']),
			new \DateTime($response['createdAt']),
			empty($response['canceledAt']) ? null : new \DateTime($response['canceledAt']),
			empty($response['closedAt']) ? null : new \DateTime($response['closedAt']),
			$response['parameters'],
			$response['amount'],
			$response['currency'],
			BillingMethod::fromResponse($response['billingMethod'])
		);
	}

    /**
	 * @return array
	 */
	public function toArray() {
		return [
			'_type'         => 'Recurring',
			'recurringId'   => $this->getRecurringId(),
			'status'        => $this->getStatus(),
			'createdAt'     => $this->getCreatedAt()->format('Y-m-d H:i:s'),
			'canceledAt'    => $this->getCanceledAt() ? $this->getCreatedAt()->format('Y-m-d H:i:s') : null,
			'closedAt'      => $this->getClosedAt() ? $this->getClosedAt()->format('Y-m-d H:i:s') : null,
			'parameters'    => $this->getParameters(),
			'billingMethod' => $this->getBillingMethod()->toArray(),
		];
	}

	/**
	 * @return int
	 */
	public function getRecurringId() {
		return $this->recurringId;
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
    public function getProviderToken() {
        return $this->providerToken;
    }

    /**
     * @return Subscription
     */
    public function getSubscription() {
        return $this->subscription;
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
	public function getCanceledAt() {
		return $this->canceledAt;
	}

	/**
	 * @return \DateTime
	 */
	public function getClosedAt() {
		return $this->closedAt;
	}

	/**
	 * @return \string[]
	 */
	public function getParameters() {
		return $this->parameters;
	}

    /**
     * @return float
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

	/**
	 * @return BillingMethod
	 */
	public function getBillingMethod() {
		return $this->billingMethod;
	}
}