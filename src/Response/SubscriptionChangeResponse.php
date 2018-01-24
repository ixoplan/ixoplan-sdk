<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class SubscriptionChangeResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\SubscriptionChangeResponseObject instead
 */
class SubscriptionChangeResponse extends SubscriptionResponse {

	/**
	 * @var bool
	 */
	private $appliedImmediately;

    /**
     * @param Subscription $subscription
     * @param bool         $needsBilling
     * @param Price        $price
     * @param bool         $appliedImmediately
     * @param bool         $requireFlexible
     */
	public function __construct(Subscription $subscription,
                                $needsBilling,
                                Price $price,
                                $appliedImmediately,
                                $requireFlexible = false
    ) {
        $this->appliedImmediately = $appliedImmediately;

        parent::__construct($subscription, $needsBilling, $price, $requireFlexible);
	}

	/**
	 * @return boolean
	 */
	public function isAppliedImmediately() {
		return $this->appliedImmediately;
	}

	/**
	 * @param array $response
	 *
	 * @return SubscriptionChangeResponse
	 */
	public static function fromResponse($response) {
		return new SubscriptionChangeResponse(
			Subscription::fromResponse($response['subscription']),
			$response['needsBilling'],
			Price::fromResponse($response['price']),
			$response['appliedImmediately'],
            isset($response['requireFlexibleForFreeUpgrade'])
                ? $response['requireFlexibleForFreeUpgrade']
                : false
		);
	}
}