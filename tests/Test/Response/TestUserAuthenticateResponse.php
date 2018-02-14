<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;
use Ixolit\Dislo\WorkingObjects\User\UserObject;

/**
 * Class TestUserAuthenticateResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserAuthenticateResponse implements TestResponseInterface {

    const ERROR_RATE_LIMIT = 'rate_limit';
    const ERROR_INVALID_CREDENTIALS = 'invalid_credentials';

    /**
     * @var UserObject
     */
    private $user;

    /**
     * @var string
     */
    private $authToken;

    /**
     * @var string|null
     */
    private $error;

    /**
     * @var string|null
     */
    private $errorCode;

    /**
     * TestUserAuthenticateResponse constructor.
     *
     * @param null $error
     */
    public function __construct($error = null) {
        $this->user = UserMock::create();
        $this->authToken = MockHelper::getFaker()->uuid;
        $this->error = $error;

        switch ($error) {
            case self::ERROR_RATE_LIMIT:
                $this->errorCode = '9099';

                break;
            case self::ERROR_INVALID_CREDENTIALS:
                $this->errorCode = '9003';

                break;
            default:
                $this->errorCode = null;
        }
    }

    /**
     * @return UserObject
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getAuthToken() {
        return $this->authToken;
    }

    /**
     * @return string|null
     */
    public function getError() {
        return $this->error;
    }

    /**
     * @return null|string
     */
    public function getErrorCode() {
        return $this->errorCode;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        if (!empty($this->getError())) {
            return [
                'user'  => null,
                'error' => $this->getError(),
                'code'  => $this->getErrorCode(),
            ];
        }

        return [
            'user'      => $this->getUser()->toArray(),
            'authToken' => $this->getAuthToken(),
        ];
    }

}