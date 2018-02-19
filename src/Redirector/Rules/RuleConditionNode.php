<?php

namespace Ixolit\Dislo\Redirector\Rules;


use Ixolit\Dislo\Redirector\Rules\Conditions\Condition;

/**
 * Class RuleConditionNode
 * @package Ixolit\Dislo\Redirector\Rules
 */
class RuleConditionNode extends RuleNode
{

    const MATCHING_AND = 'AND';
    const MATCHING_OR = 'OR';

    protected $matching;

    /**
     * @var Condition[]
     */
    protected $conditions = [];

    /**
     * @var RuleNode
     */
    protected $then;

    /**
     * @var RuleNode
     */
    protected $else;

    /**
     * @return mixed
     */
    public function getMatching()
    {
        return $this->matching;
    }

    /**
     * @param mixed $matching
     * @return RuleConditionNode
     */
    public function setMatching($matching)
    {
        $this->matching = $matching;
        return $this;
    }

    /**
     * @return Condition[]
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param Condition[] $conditions
     * @return RuleConditionNode
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @return RuleNode
     */
    public function getThen()
    {
        return $this->then;
    }

    /**
     * @param RuleNode $then
     * @return RuleConditionNode
     */
    public function setThen($then)
    {
        $this->then = $then;
        return $this;
    }

    /**
     * @return RuleNode
     */
    public function getElse()
    {
        return $this->else;
    }

    /**
     * @param RuleNode $else
     * @return RuleConditionNode
     */
    public function setElse($else)
    {
        $this->else = $else;
        return $this;
    }

}