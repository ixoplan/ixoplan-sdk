<?php


namespace Ixolit\Dislo;


use Ixolit\Dislo\Exceptions\DisloException;
use Ixolit\Dislo\Exceptions\InvalidTokenException;
use Ixolit\Dislo\Exceptions\NotImplementedException;
use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\Request\RequestClient;
use Ixolit\Dislo\Request\RequestClientExtra;
use Ixolit\Dislo\Request\RequestClientWithDevModeSupport;
use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class AbstractClient
 *
 * @package Ixolit\Dislo
 */
abstract class AbstractClient {

    const ORDER_DIR_ASC = 'ASC';
    const ORDER_DIR_DESC = 'DESC';

    /**
     * @var RequestClient
     */
    protected $requestClient;

    /**
     * @var bool
     */
    protected $forceTokenMode;

    /**
     * If the dev mode setting is enabled, additional data might be returned.
     * E.g. new plans for testing or new billing methods which are not supposed to be visible for all customers
     * @var bool
     */
    protected $devMode=false;

    /**
     * Initialize the client with a RequestClient, the class that is responsible for transporting messages to and
     * from the Dislo API.
     *
     * @param RequestClient $requestClient
     * @param bool          $forceTokenMode Force using tokens. Does not allow passing a user Id.
     */
    public function __construct(RequestClient $requestClient, $forceTokenMode = true) {
        $this->requestClient  = $requestClient;
        $this->forceTokenMode = $forceTokenMode;
    }

    /**
     * @return RequestClientExtra
     *
     * @throws NotImplementedException
     */
    protected function getRequestClientExtra() {
        if ($this->getRequestClient() instanceof RequestClientExtra) {
            /** @noinspection PhpIncompatibleReturnTypeInspection */
            return $this->requestClient;
        }

        throw new NotImplementedException();
    }

    /**
     * @param RequestClient $requestClient
     *
     * @return $this
     */
    public function setRequestClient(RequestClient $requestClient) {
        $this->requestClient = $requestClient;

        return $this;
    }

    /**
     * @return RequestClient
     */
    private function getRequestClient() {
        return $this->requestClient;
    }

    /**
     * @param bool $forceTokenMode
     *
     * @return $this
     */
    public function setForceTokenMode($forceTokenMode) {
        $this->forceTokenMode = $forceTokenMode;

        return $this;
    }

    /**
     * @return bool
     */
    public function isForceTokenMode() {
        return $this->forceTokenMode;
    }

    /**
     * @param int|string|User $userTokenOrId
     * @param array           $data
     *
     * @return array
     */
    protected function userToData($userTokenOrId, &$data = []) {

        // TODO: cleanup!

        if ($this->forceTokenMode) {
            $data['authToken'] = (string) $userTokenOrId;
            return $data;
        }
        if ($userTokenOrId instanceof User) {
            $data['userId'] = $userTokenOrId->getUserId();
            return $data;
        }
        if (\is_null($userTokenOrId)) {
            return $data;
        }
        if (\is_bool($userTokenOrId) || \is_float($userTokenOrId) || \is_resource($userTokenOrId) ||
            \is_array($userTokenOrId)
        ) {
            throw new \InvalidArgumentException('Invalid user specification: ' . \var_export($userTokenOrId, true));
        }
        if (\is_object($userTokenOrId)) {
            if (!\method_exists($userTokenOrId, '__toString')) {
                throw new \InvalidArgumentException('Invalid user specification: ' . \var_export($userTokenOrId, true));
            }
            $userTokenOrId = $userTokenOrId->__toString();
        }

        if (\is_int($userTokenOrId) || \preg_match('/^[0-9]+$/D', $userTokenOrId)) {
            $data['userId'] = (int)$userTokenOrId;
        } else {
            $data['authToken'] = $userTokenOrId;
        }
        return $data;
    }

    /**
     * Perform a request and handle errors.
     *
     * @param string $uri
     * @param array  $data
     *
     * @return array
     *
     * @throws DisloException
     * @throws ObjectNotFoundException
     */
    protected function request($uri, $data) {

        try {

            $requestClient = $this->getRequestClient();
            if ($requestClient instanceof RequestClientWithDevModeSupport) {
                $requestClient->setDevMode($this->devMode);
            }
        
            $response = $requestClient->request($uri, $data);
            if (isset($response['success']) && $response['success'] === false) {
                switch ($response['errors'][0]['code']) {
                    case 404:
                        throw new ObjectNotFoundException(
                            $response['errors'][0]['message'] . ' while trying to query ' . $uri,
                            $response['errors'][0]['code']);
                    case 9002:
                        throw new InvalidTokenException();
                    default:
                        throw new DisloException(
                            $response['errors'][0]['message'] . ' while trying to query ' . $uri,
                            $response['errors'][0]['code']);
                }
            } else {
                return $response;
            }
        } catch (ObjectNotFoundException $e) {
            throw $e;
        } catch (DisloException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new DisloException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Enable/Disable Dev mode
     * @param $enabled
     * @return $this
     */
    public function setDevMode($enabled) {
        $this->devMode = (bool) $enabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function getDevMode(){
        return $this->devMode;
    }
}