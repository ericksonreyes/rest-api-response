<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\ResourceInterface;

/**
 * Interface JsonApiResourceInterface
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
interface JsonApiResourceInterface extends ResourceInterface
{

    /**
     * @return \EricksonReyes\RestApiResponse\JsonApi\JsonApiRelationshipsInterface|null
     */
    public function relationships(): ?JsonApiRelationshipsInterface;
}
