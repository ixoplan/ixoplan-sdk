<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Subscription;

class SubscriptionCreateResponse {
	/**
	 * @var bool
	 */
	private $needsBilling;

	/**
	 * @var Price
	 */
	private $price;

	/**
	 * @var Subscription
	 */
	private $subscription;

	/** @var bool */
	private $requireFlexibleForFreeSignup;

    /**
     * @param bool         $needsBilling
     * @param Price        $price
     * @param Subscription $subscription
     * @param bool         $requireFlexibleForFreeSignup
     */
	public function __construct($needsBilling,
                                Price $price,
                                Subscription $subscription,
                                $requireFlexibleForFreeSignup = false
    ) {
        $this->needsBilling                 = $needsBilling;
        $this->price                        = $price;
        $this->subscription                 = $subscription;
        $this->requireFlexibleForFreeSignup = $requireFlexibleForFreeSignup;
    }

	/**
	 * @return boolean
	 */
	public function needsBilling() {
		return $this->needsBilling;
	}

	/**
	 * @return Price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @return Subscription
	 */
	public function getSubscription() {
		return $this->subscription;
	}

    /**
     * @return bool
     */
	public function requiresFlexibleForFreeSignup() {
	    return $this->requireFlexibleForFreeSignup;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionCreateResponse
     */
	public static function fromResponse($response) {
		return new SubscriptionCreateResponse(
			$response['needsBilling'],
			Price::fromResponse($response['price']),
			Subscription::fromResponse($response['subscription']),
            isset($response['requireFlexibleForFreeSignup'])
                ? $response['requireFlexibleForFreeSignup']
                : false
		);
	}
}