<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\BillingEvent;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjects\User;

class UserSignupWithPaymentFinishedResponse extends UserSignupWithPaymentResponse  {
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var Subscription
	 */
	private $subscription;

	/**
	 * @var BillingEvent
	 */
	private $billingEvent;

	/**
	 * @param User         $user
	 * @param Subscription $subscription
	 * @param BillingEvent $billingEvent
	 */
	public function __construct(User $user, Subscription $subscription, BillingEvent $billingEvent) {
		parent::__construct(self::STATUS_FINISHED);

		$this->user         = $user;
		$this->subscription = $subscription;
		$this->billingEvent = $billingEvent;
	}

	/**
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @return Subscription
	 */
	public function getSubscription() {
		return $this->subscription;
	}

	/**
	 * @return BillingEvent
	 */
	public function getBillingEvent() {
		return $this->billingEvent;
	}

	public static function fromResponse($response) {
		return new UserSignupWithPaymentFinishedResponse(
			User::fromResponse($response['user']),
			Subscription::fromResponse($response['subscription']),
			BillingEvent::fromResponse($response['billingEvent'])
		);
	}
}