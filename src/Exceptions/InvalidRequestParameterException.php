<?php

namespace Ixolit\Dislo\Exceptions;

/**
 * Class InvalidRequestParameterException
 *
 * @package Ixolit\Dislo\Exceptions
 */
final class InvalidRequestParameterException extends DisloException
{
    /**
     * @var array
     */
    private $parameters;

    /**
     * InvalidRequestParameterException constructor.
     *
     * @param array  $parameters
     * @param string $message
     * @param int    $code
     */
    public function __construct($parameters, $message = '', $code = 0)
    {
        parent::__construct($message, $code);

        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
