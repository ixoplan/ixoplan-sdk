<?php

namespace Ixolit\Dislo\WorkingObjects;


use Ixolit\Dislo\WorkingObjectsCustom\FlexibleCustom;


/**
 * Class Flexible
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class Flexible extends AbstractWorkingObject {

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
     * @var BillingMethod
     */
	private $billingMethodObject;

	/**
	 * @param int           	 $flexibleId
	 * @param string        	 $status
	 * @param string[]      	 $metaData
	 * @param \DateTime     	 $createdAt
	 * @param string        	 $billingMethod
	 * @param BillingMethod|null $billingMethodObject
	 */
	public function __construct(
		$flexibleId,
		$status,
		$metaData,
		\DateTime $createdAt,
		$billingMethod,
		BillingMethod $billingMethodObject = null
	) {
		$this->flexibleId    = $flexibleId;
		$this->status        = $status;
		$this->metaData      = $metaData;
		$this->createdAt     = $createdAt;
		$this->billingMethod = $billingMethod;
		$this->billingMethodObject = $billingMethodObject;

		$this->addCustomObject();
	}

    /**
     * @return FlexibleCustom|null
     */
    public function getCustom() {
        /** @var FlexibleCustom $custom */
        $custom = ($this->getCustomObject() instanceof FlexibleCustom)
            ? $this->getCustomObject()
            : null;

        return $custom;
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

    /**
	 * @return BillingMethod|null
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
            static::getValueIsSet($response, 'flexibleId'),
            static::getValueIsSet($response, 'status'),
            static::getValueIsSet($response, 'metaData'),
            static::getValueAsDateTime($response, 'createdAt'),
            static::getValueIsSet($response, 'billingMethod'),
            static::getValueIsSet($response, 'billingMethodObject', null, function ($value) {
                return BillingMethod::fromResponse($value);
            })
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            '_type'               => 'Flexible',
            'flexibleId'          => $this->getFlexibleId(),
            'status'              => $this->getStatus(),
            'metaData'            => $this->getMetaData(),
            'createdAt'           => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'billingMethod'       => $this->getBillingMethod(),
            'billingMethodObject' => $this->getBillingMethodObject()->toArray(),
        ];
    }

}