<?php

namespace Ixolit\Dislo\Redirector\Rules;


class Rule
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var RuleNode
     */
    protected $rootRuleNode;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Rule
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return RuleNode
     */
    public function getRootRuleNode()
    {
        return $this->rootRuleNode;
    }

    /**
     * @param RuleNode $rootRuleNode
     * @return Rule
     */
    public function setRootRuleNode($rootRuleNode)
    {
        $this->rootRuleNode = $rootRuleNode;
        return $this;
    }

}