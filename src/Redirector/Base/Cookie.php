<?php

namespace Ixolit\Dislo\Redirector\Base;

/**
 * Class Cookie
 * @package Ixolit\Dislo\Redirector\Base
 */
class Cookie extends NameValue {

    /**
     * @var \DateTime
     */
    protected $expirationDateTime;

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
     * @return \DateTime
     */
    public function getExpirationDateTime()
    {
        return $this->expirationDateTime;
    }

    /**
     * @param \DateTime|null $expirationDateTime
     * @return $this
     */
    public function setExpirationDateTime($expirationDateTime)
    {
        $this->expirationDateTime = $expirationDateTime ?: null;
        return $this;
    }


    /**
     * @param int $maxAge - max Age in seconds
     * @return Cookie
     */
    public function setExpirationDateTimeFromMaxAge($maxAge)
    {
        $this->expirationDateTime = new \DateTime('+ '.$maxAge.' seconds');
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHttpOnly()
    {
        return $this->httpOnly;
    }

    /**
     * @param bool $httpOnly
     * @return $this
     */
    public function setHttpOnly($httpOnly)
    {
        $this->httpOnly = $httpOnly;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequireSSL()
    {
        return $this->requireSSL;
    }

    /**
     * @param bool $requireSSL
     * @return $this
     */
    public function setRequireSSL($requireSSL)
    {
        if (is_string($requireSSL)) {
            $this->requireSSL = strtolower($requireSSL) !== 'false';
        } else {
            $this->requireSSL = (bool) $requireSSL;
        }
        $this->requireSSL = $requireSSL;
        return $this;
    }

    /**
     * @return string - e.g.: "cookieName=cookieValue; expires=Fri, 04-Aug-2017 19:06:20 GMT; Max-Age=7200; path=/; httpOnly; secure"
     */
    public function getSetCookieValueString() {
        $setCookieValueString = $this->name.'='.$this->value;

        if ($this->expirationDateTime) {
            /** @var \DateInterval $dateInterval */
            $dateInterval = $this->expirationDateTime->diff(new \DateTime());
            $maxAgeInSeconds = (int) $dateInterval->format('s');
            $setCookieValueString .= '; expires='.$this->expirationDateTime->format('D, d-M-Y H-m-s e').'; Max-Age='.$maxAgeInSeconds;
        }

        $setCookieValueString .= '; path='.$this->path;

        if ($this->httpOnly) {
            $setCookieValueString .= '; httpOnly';
        }
        if ($this->requireSSL) {
            $setCookieValueString .= '; secure';
        }

        return $setCookieValueString;
    }

}