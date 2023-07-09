<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\ResourceInterface;
use EricksonReyes\RestApiResponse\Resources;

/**
 * Interface JsonApiResources
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiResources extends Resources implements JsonApiResourcesInterface
{
    /**
     * @var \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourceInterface[]
     */
    private array $included = [];

    /**
     * @param string $name
     */
    public function __construct(private readonly string $name)
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

    /**
     * @param \EricksonReyes\RestApiResponse\ResourceInterface $resource
     * @return void
     */
    public function addIncludedResource(ResourceInterface $resource): void
    {
        $this->included[] = $resource;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\JsonApi\JsonApiResourceInterface[]
     */
    public function included(): array
    {
        return $this->included;
    }
}
