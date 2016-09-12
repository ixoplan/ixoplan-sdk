<?php
/**
 * This file is only used by the CDE to autoload classes for this library.
 */

namespace Ixolit\Dislo;

\spl_autoload_register('Ixolit\\Dislo\\autoload');

function autoload($className) {
	if (!\preg_match('/^Ixolit\\Dislo\\/', $className)) {
		return;
	}

	$file = __DIR__ . '/src/' . \str_replace('\\', '//', \preg_replace('/^Ixolit\\Dislo\\/', '', $className) . '.php');
	require_once($file);
}
