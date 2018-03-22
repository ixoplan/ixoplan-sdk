<?php

namespace Ixolit\Dislo\WorkingObjects;


use Ixolit\Dislo\WorkingObjectsCustom\BillingEventCustom;

/**
 * Class BillingEvent
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class BillingEvent extends AbstractWorkingObject {

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

    /**
     * @var BillingMethod
     */
	private $billingMethodObject;

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
        $billingMethodObject = null
    ) {
        $this->billingEventId      = $billingEventId;
        $this->userId              = $userId;
        $this->currencyCode        = $currencyCode;
        $this->amount              = $amount;
        $this->createdAt           = $createdAt;
        $this->type                = $type;
        $this->status              = $status;
        $this->description         = $description;
        $this->techinfo            = $techinfo;
        $this->billingMethod       = $billingMethod;
        $this->subscription        = $subscription;
        $this->modifiedAt          = $modifiedAt;
        $this->billingMethodObject = $billingMethodObject;

        $this->addCustomObject();
    }

    /**
     * @return BillingEventCustom|null
     */
    public function getCustom() {
        /** @var BillingEventCustom $custom */
        $custom = ($this->getCustomObject() instanceof BillingEventCustom)
            ? $this->getCustomObject()
            : null;

        return $custom;
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
     * @param array $response
     *
     * @return self
     */
    public static function fromResponse($response) {
        return new self(
            self::getValueIsSet($response, 'billingEventId'),
            static::getValueIsSet($response, 'userId'),
            static::getValueIsSet($response, 'currencyCode'),
            static::getValueIsSet($response, 'amount'),
            static::getValueAsDateTime($response, 'createdAt'),
            static::getValueIsSet($response, 'type'),
            static::getValueIsSet($response, 'status'),
            static::getValueIsSet($response, 'description'),
            static::getValueIsSet($response, 'techinfo'),
            static::getValueIsSet($response, 'billingMethod'),
            static::getValueNotEmpty($response, 'subscription', null, function ($value) {
                return Subscription::fromResponse($value);
            }),
            static::getValueAsDateTime($response, 'modifiedAt'),
            static::getValueNotEmpty($response, 'billingMethodObject', null, function ($value) {
                return BillingMethod::fromResponse($value);
            })
        );
    }

    /**
	 * @return array
	 */
	public function toArray() {
        return [
            '_type'               => 'BillingEvent',
            'billingEventId'      => $this->getBillingEventId(),
            'userId'              => $this->getUserId(),
            'currencyCode'        => $this->currencyCode,
            'amount'              => $this->getAmount(),
            'createdAt'           => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'type'                => $this->getType(),
            'status'              => $this->getStatus(),
            'description'         => $this->getDescription(),
            'techinfo'            => $this->getTechinfo(),
            'billingMethod'       => $this->getBillingMethod(),
            'subscription'        => ($this->getSubscription() ? $this->getSubscription()->toArray() : null),
            'modifiedAt'          => ($this->getModifiedAt() ? $this->getModifiedAt()->format('Y-m-d H:i:s') : null),
            'billingMethodObject' => ($this->getBillingMethodObject() ? $this->getBillingMethodObject()->toArray() : null),
        ];
    }
}