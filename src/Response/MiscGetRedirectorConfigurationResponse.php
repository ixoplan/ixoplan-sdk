<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\Redirector\Redirector;
use Ixolit\Dislo\Redirector\RulesParser;

/**
 * Class MiscGetRedirectorConfigurationResponse
 *
 * @package Ixolit\Dislo\Response
 */
class MiscGetRedirectorConfigurationResponse {

    /**
     * @var Redirector
     */
	private $redirector;

	/**
	 * @param Redirector $redirector
	 */
	public function __construct(Redirector $redirector) {
		$this->redirector = $redirector;
	}

	/**
	 * @return Redirector
	 */
	public function getRedirector() {
		return $this->redirector;
	}

	/**
	 * @param mixed $data
	 *
	 * @return self
	 */
	public static function fromData($data) {
		$parser = new RulesParser();
		$rules = $parser->buildRulesFromData($data);
		$redirector = new Redirector($rules);

		return new MiscGetRedirectorConfigurationResponse($redirector);
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return self::fromData($response);
	}

}