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
     * @param mixed $data
     *
     * @return MiscGetRedirectorConfigurationResponseObject
     */
    public static function fromData($data) {

        $parser = new RulesParser();
        $rules = $parser->buildRulesFromData($data);
        $redirector = new Redirector($rules);

        return new self($redirector);
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