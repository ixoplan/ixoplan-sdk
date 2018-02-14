<?php

namespace Ixolit\Dislo\Test\Response;


/**
 * Interface TestResponseInterface
 *
 * @package Ixolit\Dislo\Test\Response
 */
interface TestResponseInterface {

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []);

}