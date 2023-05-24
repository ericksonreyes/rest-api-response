<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\ResourcesInterface;

/**
 * Class JsonApiResponse
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiResponse implements JsonApiResponseInterface
{

    public const API_VERSION = '1.1';

    /**
     * @var \EricksonReyes\RestApiResponse\LinkInterface[]
     */
    private array $links = [];

    /**
     * @var int
     */
    private int $httpStatusCode = 200;

    /**
     * @var string
     */
    private string $httpResponseDescription = 'OK';

    /**
     * @var \EricksonReyes\RestApiResponse\ResourcesInterface|null
     */
    private ?ResourcesInterface $resources;

    /**
     * @param \EricksonReyes\RestApiResponse\ResourcesInterface $resources
     * @return void
     */
    public function withResources(ResourcesInterface $resources): void
    {
        $this->resources = $resources;
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
        return self::API_VERSION;
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
     * @return int
     */
    public function httpStatusCode(): int
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
            'jsonapi' => [
                'version' => '1.1'
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
        $resourceCount = count($this->resources);
        foreach ($this->resources as $index => $resource) {
            if ($resourceCount === 1) {
                $response['data'] = [
                    'type' => $resource->type(),
                    'id' => $resource->id(),
                    'attributes' => $resource->attributes()
                ];
                return $this->addRelationships($resource, $response, $index);
            }

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
        if ($this->resources instanceof JsonApiResourcesInterface) {
            $includedCount = count($this->resources->included());
            foreach ($this->resources->included() as $includedResource) {
                if ($includedCount === 1) {
                    $response['included'] = [
                        'type' => $includedResource->type(),
                        'id' => $includedResource->id(),
                        'attributes' => $includedResource->attributes(),
                    ];
                    return $response;
                }

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
     * @param \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourceInterface $resource
     * @param array $response
     * @param int $index
     * @return array
     */
    private function addRelationships(JsonApiResourceInterface $resource, array $response, int $index): array
    {
        if ($resource->relationships() instanceof JsonApiRelationships) {
            $relationshipCount = count($resource->relationships());
            foreach ($resource->relationships() as $relationship) {
                /**
                 * @var \EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationshipInterface $relationship
                 */
                $relationshipName = $resource->relationships()->name();

                if ($relationshipCount === 1) {
                    $response['data'][$index]['relationships'][$relationshipName]['data'] = [
                        'id' => $relationship->id(),
                        'type' => $relationship->type()
                    ];
                    return $response;
                }

                $response['data'][$index]['relationships'][$relationshipName]['data'][] = [
                    'id' => $relationship->id(),
                    'type' => $relationship->type()
                ];
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
