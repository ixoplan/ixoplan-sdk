<?php

namespace Ixolit\Dislo\Response\Redirector;


use Ixolit\Dislo\Redirector\Redirector;
use Ixolit\Dislo\Redirector\RulesParser;

/**
 * Class MiscGetRedirectorConfigurationResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class MiscGetRedirectorConfigurationResponseObject {

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
     * @param array $response
     *
     * @return self
     */
    public static function fromResponse($response) {
        $parser = new RulesParser();
        $rules = $parser->buildRulesFromData($response);
        $redirector = new Redirector($rules);

        return new self($redirector);
    }


}