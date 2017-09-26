<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjects\Subscription;

class SubscriptionCreateResponse extends SubscriptionResponse {

    /**
     * @param bool         $needsBilling
     * @param Price        $price
     * @param Subscription $subscription
     * @param bool         $requireFlexible
     */
	public function __construct($needsBilling,
                                Price $price,
                                Subscription $subscription,
                                $requireFlexible = false
    ) {
        parent::__construct($subscription, $needsBilling, $price, $requireFlexible);
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