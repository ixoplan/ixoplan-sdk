<?php

namespace Ixolit\Dislo\Redirector;

use Ixolit\Dislo\Redirector\Base\RedirectorInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;
use Ixolit\Dislo\Redirector\Rules\Actions\Action;
use Ixolit\Dislo\Redirector\Rules\Conditions\Condition;
use Ixolit\Dislo\Redirector\Rules\Rule;
use Ixolit\Dislo\Redirector\Rules\RuleConditionNode;
use Ixolit\Dislo\Redirector\Rules\RuleNode;

/**
 * Class Redirector
 * @package Ixolit\Dislo\Redirector
 */
class Redirector implements RedirectorInterface
{

    /**
     * @var Rule[]
     */
    protected $rules;

    /**
     * @var bool
     */
    protected $break;

    /**
     * RulesEvaluator constructor.
     * @param Rule[] $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;

    }

    public function doBreak() {
        $this->break = true;
    }

    /**
     * @return bool
     */
    public function isBreak() {
        return $this->break;
    }

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @return $this
     */
    public function evaluate(RedirectorRequestInterface $request, RedirectorResultInterface $result) {

        foreach ($this->rules as $rule) {

            $this->evaluateRuleNode($request, $result, $rule->getRootRuleNode());

            if ($this->isBreak()) {
                break;
            }
        }
        return $this;
    }

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @param RuleNode|null $ruleNode
     */
    protected function evaluateRuleNode(RedirectorRequestInterface $request, RedirectorResultInterface $result, RuleNode $ruleNode = null) {
        if (!$ruleNode) {
            return;
        }
        if ($ruleNode instanceof RuleConditionNode) {
            /** @var RuleConditionNode $ruleNode */
            if ($this->evaluateConditions($request, $result, $ruleNode->getConditions(), $ruleNode->getMatching())) {
                $this->evaluateRuleNode($request, $result, $ruleNode->getThen());
            } else {
                $this->evaluateRuleNode($request, $result, $ruleNode->getElse());
            }
        } else {
            /** @var Action $ruleNode */
            $ruleNode->process($this, $result, $request);
        }

        if (!$this->isBreak()) {
            $this->evaluateRuleNode($request, $result, $ruleNode->getNext());
        }
    }

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @param Condition[] $conditions
     * @param string $matching
     * @return bool
     */
    protected function evaluateConditions($request, $result, $conditions, $matching) {

        foreach ($conditions as $condition) {
            $singleConditionResult = $condition->evaluateFromRequest($this, $request, $result);

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