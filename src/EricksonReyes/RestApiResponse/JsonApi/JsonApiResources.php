<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\Resources;

/**
 * Interface JsonApiResources
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiResources extends Resources implements JsonApiResourcesInterface
{

    /**
     * @param string $name
     */
    public function __construct(private readonly string $name = 'data')
    {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}
