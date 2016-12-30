<?php

namespace Ixolit\Dislo\Request;

use Ixolit\Dislo\Exceptions\DisloException;
use Ixolit\Dislo\HTTP\HTTPClientAdapter;

/**
 * This client uses a PSR-7 client to talk to Dislo.
 *
 * @package Dislo
 */
class HTTPRequestClient implements RequestClient {

	/**
	 * @var HTTPClientAdapter
	 */
	private $httpClient;
	/**
	 * @var
	 */
	private $host;
	/**
	 * @var TimeProvider
	 */
	private $timeProvider;
	/**
	 * @var
	 */
	private $apiKey;
	/**
	 * @var
	 */
	private $apiSecret;

	/**
	 * @param HTTPClientAdapter $httpClient
	 * @param string            $host
	 * @param string            $apiKey
	 * @param string            $apiSecret
	 * @param TimeProvider|null $timeProvider
	 */
	public function __construct(
		HTTPClientAdapter $httpClient,
		$host,
		$apiKey,
		$apiSecret,
		TimeProvider $timeProvider = null
	) {
		if (!$timeProvider) {
			$timeProvider = new StandardTimeProvider();
		}
		$this->httpClient   = $httpClient;
		$this->host         = $host;
		$this->timeProvider = $timeProvider;
		$this->apiKey       = $apiKey;
		$this->apiSecret    = $apiSecret;
	}

	/**
	 * @param string $uri
	 * @param array  $params
	 *
	 * @return array
	 *
	 * @throws DisloException
	 * @throws InvalidResponseData
	 */
	public function request($uri, array $params) {
		$payload   = \json_encode($params);
		$uri       = $this->httpClient->createUri()
		                              ->withScheme('https')
		                              ->withHost($this->host)
		                              ->withPath($uri)
		                              ->withQuery(
			                              'api_key=' . \urlencode($this->apiKey) .
			                              '&timestamp=' . \urlencode($this->timeProvider->getTimestamp()));
		$signature = \hash_hmac('MD5', $uri->getPath() . '?' . $uri->getQuery() . $payload, $this->apiSecret);
		$uri       = $uri->withQuery($uri->getQuery() . '&signature=' . \urlencode($signature));
		$request   = $this->httpClient->createRequest()
		                              ->withUri($uri)
		                              ->withMethod('POST')
		                              ->withHeader('Content-Type', 'text/json')
		                              ->withBody($this->httpClient->createStringStream($payload));

		$response = $this->httpClient->send($request);

		$decodedBody = \json_decode($response->getBody(), true);

		if (\json_last_error() == JSON_ERROR_NONE) {
			return $decodedBody;
		}

		throw new InvalidResponseData($response->getBody());
	}
}