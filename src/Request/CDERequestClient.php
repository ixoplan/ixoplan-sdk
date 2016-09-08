<?php

namespace Ixolit\Dislo\Request;

/**
 * This client uses the CDE-internal API to talk to Dislo.
 *
 * @package Dislo
 */
class CDERequestClient implements RequestClient {

	/**
	 * @param string $uri
	 * @param array  $params
	 *
	 * @return string
	 *
	 * @throws InvalidResponseData
	 */
	public function request($uri, array $params) {
		$response = \apiCall('dislo',$uri,\json_encode($params));

		$decodedBody = \json_decode($response->body);
		if (\json_last_error() == JSON_ERROR_NONE) {
			return $decodedBody;
		}

		throw new InvalidResponseData($response->body);
	}
}