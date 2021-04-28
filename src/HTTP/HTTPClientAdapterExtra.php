<?php

namespace Ixolit\Dislo\HTTP;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @package Ixolit\Dislo\HTTP
 */
interface HTTPClientAdapterExtra {

	const OPTION_RESPONSE_BODY_STREAM = 'response_body_stream';

	/**
	 * @param RequestInterface $request
	 * @param array $options
	 *
	 * @return ResponseInterface
	 */
	public function sendAdvanced(RequestInterface $request, array $options);
}