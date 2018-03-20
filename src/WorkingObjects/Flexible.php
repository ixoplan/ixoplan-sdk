<?php

namespace Ixolit\Dislo\WorkingObjects;


/**
 * Class Flexible
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
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
        return new Flexible(
            $response['flexibleId'],
            $response['status'],
            $response['metaData'],
            new \DateTime($response['createdAt']),
            $response['billingMethod'],
            isset($response['billingMethodObject']) ? BillingMethod::fromResponse($response['billingMethodObject']) : null
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