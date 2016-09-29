<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\BillingEvent;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjects\User;

class UserGetSignupStatusResponse {
	const STATUS_FINISHED = 'finished';
	const STATUS_FAILED   = 'failed';
	const STATUS_PENDING  = 'pending';
	const STATUS_TIMEOUT  = 'timeout';

	/**
	 * @var string
	 *
	 * @see self::STATUS_*
	 */
	private $status;

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
	 * @param string       $status
	 * @param User         $user
	 * @param Subscription $subscription
	 * @param BillingEvent $billingEvent
	 */
	public function __construct($status, User $user, Subscription $subscription, BillingEvent $billingEvent) {
		$this->status       = $status;
		$this->user         = $user;
		$this->subscription = $subscription;
		$this->billingEvent = $billingEvent;
	}

	/**
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
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
		return new UserGetSignupStatusResponse(
			$response['status'],
			User::fromResponse($response['user']),
			Subscription::fromResponse($response['subscription']),
			BillingEvent::fromResponse($response['billingEvent'])
		);
	}
}