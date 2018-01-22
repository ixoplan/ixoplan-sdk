<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\Plan;


/**
 * Class PlanGetResponse
 *
 * @package Ixolit\Dislo\Response
 */
class PlanGetResponse {

    /**
     * @var Plan
     */
    private $plan;

    /**
     * @param Plan $plan
     */
    public function __construct(Plan $plan) {
        $this->plan = $plan;
    }

    /**
     * @return Plan
     */
    public function getPlan() {
        return $this->plan;
    }

}