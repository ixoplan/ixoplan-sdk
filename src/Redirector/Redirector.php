<?php

namespace Ixolit\Dislo\Redirector;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;
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
     * @return RedirectorResult
     */
    public function evaluate(RedirectorRequestInterface $request) {

        $result = new RedirectorResult();

        foreach ($this->rules as $rule) {

            $this->evaluateRuleNode($result, $request, $rule->getRootRuleNode());

            if ($result->isRedirect() !== null) {
                return $result;
            }
        }

        return $result->setRedirect(false);
    }

    /**
     * @param RequestResolverInterface $resolver
     * @return RedirectorResult
     */
    public function evaluateFromResolver(RequestResolverInterface $resolver) {
        $redirectorRequest = $resolver->getRedirectorRequest();

        return $this->evaluate($redirectorRequest);
    }

    /**
     * @param RedirectorResult $result
     * @param RedirectorRequestInterface $request
     * @param RuleNode|null $ruleNode
     */
    protected function evaluateRuleNode(RedirectorResult &$result, RedirectorRequestInterface $request, RuleNode $ruleNode = null) {
        if (!$ruleNode) {
            return;
        }
        if ($ruleNode instanceof RuleConditionNode) {
            /** @var RuleConditionNode $ruleNode */
            if ($this->evaluateConditions($result, $request, $ruleNode->getConditions(), $ruleNode->getMatching())) {
                $this->evaluateRuleNode($result, $request, $ruleNode->getThen());
            } else {
                $this->evaluateRuleNode($result, $request, $ruleNode->getElse());
            }
        } else {
            /** @var Action $ruleNode */
            $ruleNode->process($result, $request);
        }

        if ($result->isRedirect() === null) {
            $this->evaluateRuleNode($result, $request, $ruleNode->getNext());
        }

    }

    /**
     * @param RedirectorResult $result
     * @param RedirectorRequestInterface $request
     * @param Condition[] $conditions
     * @param string $matching
     * @return bool
     */
    protected function evaluateConditions($result, $request, $conditions, $matching) {

        foreach ($conditions as $condition) {
            $singleConditionResult = $condition->evaluate($result, $request);

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