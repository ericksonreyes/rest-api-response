<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\LinksInterface;

/**
 * Interface JsonApiRelationshipsInterface
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
interface JsonApiRelationshipsInterface extends \Iterator, \Countable
{

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return \EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationshipInterface[]
     */
    public function relationships(): array;

    /**
     * @return \EricksonReyes\RestApiResponse\LinksInterface
     */
    public function links(): LinksInterface;
}
