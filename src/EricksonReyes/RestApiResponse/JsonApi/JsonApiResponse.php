<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\ResourceInterface;
use EricksonReyes\RestApiResponse\ResourcesInterface;

/**
 * Class JsonApiResponse
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiResponse implements JsonApiResponseInterface
{

    /**
     * @var \EricksonReyes\RestApiResponse\LinkInterface[]
     */
    private array $links = [];

    /**
     * @var \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourceInterface[]
     */
    private array $included = [];

    /**
     * @var int
     */
    private int $httpStatusCode = 200;

    private string $httpResponseDescription = 'OK';

    /**
     * @param \EricksonReyes\RestApiResponse\ResourcesInterface $resources
     */
    public function __construct(private readonly ResourcesInterface $resources)
    {
    }


    /**
     * @return string
     */
    public function mediaType(): string
    {
        return JsonApiResponseMediaTypeInterface::RESPONSE_MEDIA_TYPE_JSON_API;
    }

    /**
     * @return string
     */
    public function specificationName(): string
    {
        return 'jsonapi';
    }

    /**
     * @return string
     */
    public function specificationVersion(): string
    {
        return '1.1';
    }

    /**
     * @param int $httpStatusCode
     * @return void
     */
    public function setHttpStatusCode(int $httpStatusCode): void
    {
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * @param string $httpResponseDescription
     * @return void
     */
    public function describeHttpResponse(string $httpResponseDescription): void
    {
        $this->httpResponseDescription = $httpResponseDescription;
    }

    /**
     * @return string
     */
    public function httpStatusCode(): string
    {
        return $this->httpStatusCode;
    }

    /**
     * @return string
     */
    public function httpResponseDescription(): string
    {
        return $this->httpResponseDescription;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $response = [
            [
                'jsonapi' => [
                    'version' => '1.1'
                ]
            ],
            'data' => []
        ];

        $response = $this->addResources($response);
        $response = $this->addIncludedResources($response);
        return $this->addLinks($response);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->array(), JSON_PRETTY_PRINT);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->array();
    }

    /**
     * @param array $response
     * @return array
     */
    private function addResources(array $response): array
    {
        foreach ($this->resources->data() as $index => $resource) {
            $response['data'][$index] = [
                'type' => $resource->type(),
                'id' => $resource->id(),
                'attributes' => $resource->attributes()
            ];

            $response = $this->addRelationships($resource, $response, $index);
        }
        
        return $response;
    }

    /**
     * @param array $response
     * @return array
     */
    private function addIncludedResources(array $response): array
    {
        if (empty($this->included) === false) {
            foreach ($this->included as $includedResource) {
                $response['included'][] = [
                    'type' => $includedResource->type(),
                    'id' => $includedResource->id(),
                    'attributes' => $includedResource->attributes(),
                ];
            }
        }
        return $response;
    }

    /**
     * @param \EricksonReyes\RestApiResponse\ResourceInterface $resource
     * @param array $response
     * @param int $index
     * @return array
     */
    private function addRelationships(ResourceInterface $resource, array $response, int $index): array
    {
        if ($resource instanceof JsonApiResourceInterface) {
            foreach ($resource->relationships() as $relationship) {
                $relationshipName = $relationship->name();
                foreach ($relationship->data() as $relatedResource) {
                    $response['data'][$index]['relationships'][$relationshipName]['data'][] = [
                        'id' => $relatedResource->id(),
                        'type' => $relatedResource->type()
                    ];
                }
            }
        }
        return $response;
    }

    /**
     * @param array $response
     * @return array
     */
    private function addLinks(array $response): array
    {
        if (empty($this->links) === false) {
            foreach ($this->links as $link) {
                $response['links'][$link->name()] = $link->url();
            }
        }
        return $response;
    }


}
