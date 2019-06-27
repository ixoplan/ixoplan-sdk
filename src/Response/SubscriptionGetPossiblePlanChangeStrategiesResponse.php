<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\PlanChangeStrategy;

/**
 * Class SubscriptionGetPossiblePlanChangeStrategiesResponse
 * @package Ixolit\Dislo\Response
 */
class SubscriptionGetPossiblePlanChangeStrategiesResponse {

	/**
	 * @var PlanChangeStrategy[]
	 */
	private $strategies = [];

	/**
	 * @param PlanChangeStrategy[] $strategies
	 */
	public function __construct(array $strategies) {
		$this->strategies = $strategies;
	}

	/**
	 * @return PlanChangeStrategy[]
	 */
	public function getStrategies() {
		return $this->strategies;
	}

	/**
	 * @param $data
	 * @return SubscriptionGetPossiblePlanChangeStrategiesResponse
	 */
	public static function fromResponse($data) {
		$result = [];
		foreach ($data['strategies'] as $strategy) {
				$result[] = PlanChangeStrategy::fromResponse($strategy);
		}

		return new SubscriptionGetPossiblePlanChangeStrategiesResponse($result);
	}

}