<?php

namespace Ixolit\Dislo\Redirector\Rules;

/**
 * Class RuleNode
 * @package Ixolit\Dislo\Redirector\Rules
 */
class RuleNode
{


    /**
     * @var RuleNode
     */
    protected $next;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return RuleNode
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return RuleNode
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param RuleNode $next
     * @return RuleNode
     */
    public function setNext($next)
    {
        $this->next = $next;
        return $this;
    }

}