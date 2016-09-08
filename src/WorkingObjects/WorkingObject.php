<?php

namespace Ixolit\Dislo\WorkingObjects;

interface WorkingObject {
	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse(array $response);

	/**
	 * @return array
	 */
	public function toArray();
}