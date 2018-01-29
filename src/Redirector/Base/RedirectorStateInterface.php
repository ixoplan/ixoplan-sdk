<?php

namespace Ixolit\Dislo\Redirector\Base;

interface RedirectorStateInterface {

	public function doBreak();

	/**
	 * @return bool
	 */
	public function isBreak();
}