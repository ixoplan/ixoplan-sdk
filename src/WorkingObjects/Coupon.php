<?php

namespace Ixolit\Dislo\WorkingObjects;


use Ixolit\Dislo\WorkingObjectsCustom\CouponCustom;


/**
 * Class Coupon
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class Coupon extends AbstractWorkingObject {

    const COUPON_EVENT_START = 'subscription_start';
    const COUPON_EVENT_UPGRADE = 'subscription_upgrade';

    /**
     * @var string
     */
	private $code;

    /**
     * @var string
     */
	private $description;

	/**
	 * Coupon constructor.
	 *
	 * @param string $code
	 * @param string $description
	 */
	public function __construct($code, $description) {
		$this->code = $code;
		$this->description = $description;

		$this->addCustomObject();
	}

    /**
     * @return CouponCustom|null
     */
    public function getCustom() {
        /** @var CouponCustom $custom */
        $custom = ($this->getCustomObject() instanceof CouponCustom)
            ? $this->getCustomObject()
            : null;

        return $custom;
    }

	/**
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return new self(
            static::getValueIsSet($response, 'code'),
            static::getValueIsSet($response, 'description')
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
        return [
            'code'        => $this->code,
            'description' => $this->description,
        ];
	}
}