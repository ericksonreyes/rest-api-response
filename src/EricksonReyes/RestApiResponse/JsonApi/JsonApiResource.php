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
     * @var \EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationshipsInterface|null
     */
    private ?JsonApiRelationshipsInterface $relationships;


    /**
     * @param \EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationshipsInterface $relationships
     * @return void
     */
    public function withRelationships(JsonApiRelationshipsInterface $relationships): void
    {
        $this->relationships = $relationships;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationshipsInterface
     */
    public function relationships(): JsonApiRelationshipsInterface
    {
        return $this->relationships;
    }


}