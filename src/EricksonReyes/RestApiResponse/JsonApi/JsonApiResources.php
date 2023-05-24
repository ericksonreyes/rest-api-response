<?php

namespace EricksonReyes\RestApiResponse\JsonApi;


use EricksonReyes\RestApiResponse\ResourceInterface;
use EricksonReyes\RestApiResponse\Resources;
use EricksonReyes\RestApiResponse\ResourcesInterface;

/**
 * Interface JsonApiResources
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiResources extends Resources implements JsonApiResourcesInterface
{
    /**
     * @var array
     */
    private array $includedResources = [];

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
    public function includeResource(ResourceInterface $resource): void
    {
        $this->includedResources[] = $resource;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\ResourcesInterface
     */
    public function included(): ResourcesInterface
    {
        return $this->includedResources;
    }

}