<?php

namespace EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\ResourcesInterface;

/**
 * Interface JsonApiResourcesInterface
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
interface JsonApiResourcesInterface extends ResourcesInterface
{

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return \EricksonReyes\RestApiResponse\ResourcesInterface
     */
    public function included(): ResourcesInterface;
}
