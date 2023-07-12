<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\Resource;

/**
 * Interface JsonApiResource
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiResource extends Resource implements JsonApiResourceInterface
{

    /**
     * @var \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourceInterface[]
     */
    private array $relationships = [];


    /**
     * @param string $id
     * @param string $type
     * @param array $attributes
     */
    public function __construct(
        private readonly string $id,
        private readonly string $type,
        array                   $attributes
    ) {
        parent::__construct($this->id, $this->type, $attributes);
    }

    /**
     * @param string $relation
     * @param \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourceInterface $resource
     * @return void
     */
    public function addRelationship(string $relation, JsonApiResourceInterface $resource): void
    {
        $this->relationships[$relation] = $resource;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourceInterface[]
     */
    public function relationships(): array
    {
        return $this->relationships;
    }
}
