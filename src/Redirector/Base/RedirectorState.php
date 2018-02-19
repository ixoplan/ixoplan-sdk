<?php

namespace Ixolit\Dislo\Redirector\Base;

class RedirectorState implements RedirectorStateInterface {

    /**
     * @var bool
     */
    protected $break;

    public function doBreak() {
        $this->break = true;
    }

    /**
     * @return bool
     */
    public function isBreak() {
        return $this->break;
    }

}