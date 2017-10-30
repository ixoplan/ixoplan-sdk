<?php

namespace Ixolit\Dislo\Redirector\Base;

use Ixolit\Dislo\Redirector\Rules\Actions\Action;
use Ixolit\Dislo\Redirector\Rules\Conditions\Condition;

/**
 * Class Factory
 * @package Ixolit\Dislo\Redirector\Base
 */
class Factory
{

    /**
     * @param array $actionData
     * @return Action
     * @throws \Exception
     */
    public function createActionFromArray($actionData) {
        $className = "Ixolit\\Dislo\\Redirector\\Rules\\Actions\\".$actionData['type'];

        if (!class_exists($className)) {
            throw new \Exception(__METHOD__.': Class '.$className.' does not exist.');
        }

        /**
         * @var Action $action
         */
        $action = new $className;

        if (! $action instanceof  Action) {
            throw new \Exception(__METHOD__.': Class '.$className.' is not type of Action.');
        }

        if (!empty($actionData['data'])) {
            $action->setParameters($actionData['data'] ?: []);
        }

        return $action;
    }

    /**
     * @param $conditionData
     * @return Condition
     * @throws \Exception
     */
    public function createConditionFromArray($conditionData) {
        $className = "Ixolit\\Dislo\\Redirector\\Rules\\Conditions\\".$conditionData['type'];

        if (!class_exists($className)) {
            throw new \Exception('Class '.$className.' does not exist.');
        }

        /**
         * @var Condition $condition
         */
        $condition = new $className;

        if (! $condition instanceof  Condition) {
            throw new \Exception('Class '.$className.' is not type of Condition');
        }

        $condition->setParameters($conditionData['data'] ?: []);

        return $condition;

    }

}