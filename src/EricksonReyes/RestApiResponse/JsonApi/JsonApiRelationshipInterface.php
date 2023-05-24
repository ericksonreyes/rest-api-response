<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

/**
 * Interface JsonApiResourceRelationshipInterface
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
interface JsonApiRelationshipInterface
{

    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return string
     */
    public function type(): string;
}
