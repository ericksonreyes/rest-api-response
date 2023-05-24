<?php

namespace EricksonReyes\RestApiResponse\JsonApi;


/**
 * Class JsonApiRelationship
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiRelationship implements JsonApiRelationshipInterface
{

    /**
     * @param string $id
     * @param string $type
     */
    public function __construct(private readonly string $id, private readonly string $type)
    {
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }


}