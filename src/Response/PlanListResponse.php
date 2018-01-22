<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\Plan;


/**
 * Class PlanListResponse
 *
 * @package Ixolit\Dislo\Response
 */
class PlanListResponse {

    /**
     * @var Plan[]
     */
    private $plans;

    /**
     * @param Plan[] $plans
     */
    public function __construct(array $plans) {
        $this->plans = $plans;
    }

    /**
     * @return Plan[]
     */
    public function getPlans() {
        return $this->plans;
    }

    /**
     * @param array $response
     *
     * @return PlanListResponse
     */
    public static function fromResponse($response) {
        $plans = [];
        foreach ($response['packages'] as $packageDefinition) {
            $plans[] = Plan::fromResponse($packageDefinition);
        }

        return new self($plans);
    }

}