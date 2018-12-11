<?php

namespace Ixolit\Dislo\Redirector;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorState;
use Ixolit\Dislo\Redirector\Base\RedirectorStateInterface;
use Ixolit\Dislo\Redirector\Rules\Actions\Action;
use Ixolit\Dislo\Redirector\Rules\Conditions\Condition;
use Ixolit\Dislo\Redirector\Rules\Rule;
use Ixolit\Dislo\Redirector\Rules\RuleConditionNode;
use Ixolit\Dislo\Redirector\Rules\RuleNode;

/**
 * Class Redirector
 * @package Ixolit\Dislo\Redirector
 */
class Redirector
{

    /**
     * @var Rule[]
     */
    protected $rules;

    /**
     * RulesEvaluator constructor.
     * @param Rule[] $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;

    }

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @return RedirectorState
     */
    public function evaluate(RedirectorRequestInterface $request, RedirectorResultInterface $result) {

        $state = new RedirectorState();
        $this->evaluateRules($state, $request, $result);

        return $state;
    }

    /**
     * @param RedirectorStateInterface $state
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     */
    protected function evaluateRules(RedirectorStateInterface $state, RedirectorRequestInterface $request, RedirectorResultInterface $result) {

        foreach ($this->rules as $rule) {

            $this->evaluateRuleNode($state, $request, $result, $rule->getRootRuleNode());

            if ($state->isBreak()) {
                break;
            }
        }
    }

    /**
     * @param RedirectorStateInterface $state
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @param RuleNode|null $ruleNode
     */
    protected function evaluateRuleNode(RedirectorStateInterface $state, RedirectorRequestInterface $request, RedirectorResultInterface $result, RuleNode $ruleNode = null) {
        if (!$ruleNode) {
            return;
        }
        if ($ruleNode instanceof RuleConditionNode) {
            /** @var RuleConditionNode $ruleNode */
            if ($this->evaluateConditions($state, $request, $result, $ruleNode->getConditions(), $ruleNode->getMatching())) {
                $this->evaluateRuleNode($state, $request, $result, $ruleNode->getThen());
            } else {
                $this->evaluateRuleNode($state, $request, $result, $ruleNode->getElse());
            }
        } else {
            /** @var Action $ruleNode */
            $ruleNode->process($state, $result, $request);
        }

        if (!$state->isBreak()) {
            $this->evaluateRuleNode($state, $request, $result, $ruleNode->getNext());
        }
    }

    /**
     * @param RedirectorStateInterface $state
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @param Condition[] $conditions
     * @param string $matching
     * @return bool
     */
    protected function evaluateConditions(RedirectorStateInterface $state, RedirectorRequestInterface $request, RedirectorResultInterface $result, $conditions, $matching) {

        foreach ($conditions as $condition) {
            $singleConditionResult = $condition->evaluateFromRequest($state, $request, $result);

            // if matching == 'OR' return true if any condition is true
            if ($matching === RuleConditionNode::MATCHING_OR && $singleConditionResult) {
                return true;
            }

            // if matching == 'AND' return false if any condition is false
            if ($matching !== RuleConditionNode::MATCHING_OR && !$singleConditionResult) {
                return false;
            }
        }

        return $matching === RuleConditionNode::MATCHING_OR ? false : true;

    }

}