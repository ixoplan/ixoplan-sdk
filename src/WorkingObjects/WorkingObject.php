<?php

namespace Ixolit\Dislo\WorkingObjects;

interface WorkingObject {
	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response);

	/**
	 * @return array
	 */
	public function toArray();
}