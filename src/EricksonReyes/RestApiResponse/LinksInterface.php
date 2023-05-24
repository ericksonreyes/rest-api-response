<?php

namespace EricksonReyes\RestApiResponse;

use Iterator;

/**
 * Interface LinksInterface
 * @package EricksonReyes\RestApiResponse
 */
interface LinksInterface extends Iterator, \Countable
{

    /**
     * @return \EricksonReyes\RestApiResponse\LinkInterface[]
     */
    public function links(): array;
}
