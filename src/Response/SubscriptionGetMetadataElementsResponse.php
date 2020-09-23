<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\SubscriptionMetadataElement;

/**
 * Class SubscriptionGetMetadataElementsResponse
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionGetMetadataElementsResponse
{
    /**
     * @var SubscriptionMetadataElement[]
     */
    private $metadataElements;

    /**
     * SubscriptionGetMetadataElementsResponse constructor.
     *
     * @param SubscriptionMetadataElement[] $metadataElements
     */
    public function __construct($metadataElements)
    {
        $this->metadataElements = $metadataElements;
    }

    /**
     * @return SubscriptionMetadataElement[]
     */
    public function getMetadataElements()
    {
        return $this->metadataElements;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionGetMetadataElementsResponse
     */
    public static function fromResponse($response)
    {
        return new SubscriptionGetMetadataElementsResponse(\array_map(
            function ($metadataElement) {
                return SubscriptionMetadataElement::fromResponse($metadataElement);
            },
            $response['metadataElements']
        ));
    }
}
