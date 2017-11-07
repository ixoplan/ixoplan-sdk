<?php

namespace Ixolit\Dislo\Redirector\Base;

use Ixolit\Dislo\Exceptions\RedirectorException;
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
     * @throws RedirectorException
     */
    public function createActionFromArray($actionData) {
        $className = "Ixolit\\Dislo\\Redirector\\Rules\\Actions\\".$actionData['type'];

        if (!class_exists($className)) {
            throw new RedirectorException(__METHOD__.': Class '.$className.' does not exist.');
        }

        /**
         * @var Action $action
         */
        $action = new $className;

        if (! $action instanceof  Action) {
            throw new RedirectorException(__METHOD__.': Class '.$className.' is not type of Action.');
        }

        if (!empty($actionData['data'])) {
            $action->setParameters($actionData['data'] ?: []);
        }

        return $action;
    }

    /**
     * @param $conditionData
     * @return Condition
     * @throws RedirectorException
     */
    public function createConditionFromArray($conditionData) {
        $className = "Ixolit\\Dislo\\Redirector\\Rules\\Conditions\\".$conditionData['type'];

        if (!class_exists($className)) {
            throw new RedirectorException('Class '.$className.' does not exist.');
        }

        /**
         * @var Condition $condition
         */
        $condition = new $className;

        if (! $condition instanceof  Condition) {
            throw new RedirectorException('Class '.$className.' is not type of Condition');
        }

        $condition->setParameters($conditionData['data'] ?: []);

        return $condition;

    }

}