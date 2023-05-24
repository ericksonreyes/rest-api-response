<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\Collection;
use EricksonReyes\RestApiResponse\LinksInterface;

/**
 * Class JsonApiRelationships
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiRelationships extends Collection implements JsonApiRelationshipsInterface
{

    /**
     * @var \EricksonReyes\RestApiResponse\LinksInterface|null
     */
    private ?LinksInterface $links;

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
     * @param \EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationshipInterface $relationship
     * @return void
     */
    public function addRelationship(JsonApiRelationshipInterface $relationship): void
    {
        $this->addItem($relationship);
    }

    /**
     * @return \EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationshipInterface[]
     */
    public function relationships(): array
    {
        return $this->items();
    }

    /**
     * @param \EricksonReyes\RestApiResponse\LinksInterface $links
     * @return void
     */
    public function withLinks(LinksInterface $links): void
    {
        $this->links = $links;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\LinksInterface
     */
    public function links(): LinksInterface
    {
        return $this->links;
    }
}
