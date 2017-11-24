<?php

namespace Ixolit\Dislo\Redirector\Rules\Actions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\Cookie;
use Ixolit\Dislo\Redirector\Base\RedirectorStateInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;
use Ixolit\Dislo\Redirector\Redirector;

/**
 * Class SetCookie
 * @package Ixolit\Dislo\Redirector\Rules\Actions
 */
class SetCookie extends Action
{

    const DEFAULT_VALUE_HTTP_ONLY = true;
    const DEFAULT_VALUE_REQUIRE_SSL = true;
    const DEFAULT_VALUE_PATH = '/';

    /**
     * @var string
     */
    protected $cookieName;

    /**
     * @var string
     */
    protected $cookieValue;

    /**
     * @var int
     */
    protected $maxAge;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var bool
     */
    protected $httpOnly;

    /**
     * @var bool
     */
    protected $requireSSL;

    /**
     * @param array $parameters
     * @throws RedirectorException
     */
    protected function validateParameters($parameters) {
        if (empty($parameters['cookieName'])) {
            throw new RedirectorException(__METHOD__.': Missing parameter "cookieName"');
        }
        if (empty($parameters['cookieValue'])) {
            throw new RedirectorException(__METHOD__.': Missing parameter "cookieValue"');
        }
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->validateParameters($parameters);

        $this->cookieName = $parameters['cookieName'];
        $this->cookieValue = $parameters['cookieValue'];
        $this->maxAge = !empty($parameters['maxAge']) ? (int) $parameters['maxAge'] : null;
        $this->path = !empty($parameters['path']) ? $parameters['path'] : self::DEFAULT_VALUE_PATH;
        $this->httpOnly = !empty($parameters['httpOnly']) ? $parameters['httpOnly'] !== 'false' : self::DEFAULT_VALUE_HTTP_ONLY;
        $this->requireSSL = !empty($parameters['requireSSL']) ? $parameters['requireSSL'] !== 'false' : self::DEFAULT_VALUE_REQUIRE_SSL;

        return $this;
    }

    /**
     * @param RedirectorStateInterface $redirectorState
     * @param RedirectorResultInterface $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     */
    public function process(RedirectorStateInterface $redirectorState, RedirectorResultInterface $redirectorResult, RedirectorRequestInterface $redirectorRequest)
    {

        $cookie = new Cookie();
        $cookie->setName($this->cookieName)
            ->setValue($this->cookieValue)
            ->setPath($this->path)
            ->setHttpOnly($this->httpOnly)
            ->setRequireSSL($this->requireSSL);

        if ($this->maxAge) {
            $cookie->setExpirationDateTimeFromMaxAge($this->maxAge);
        }

        $redirectorResult->setCookie($cookie);

    }

}