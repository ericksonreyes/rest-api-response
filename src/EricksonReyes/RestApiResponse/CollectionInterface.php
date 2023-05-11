<?php

namespace EricksonReyes\RestApiResponse;


use Countable;
use Iterator;

/**
 * Interface CollectionInterface
 * @package EricksonReyes\RestApiResponse
 */
interface CollectionInterface extends Iterator, Countable
{

    /**
     * @return \EricksonReyes\RestApiResponse\ResourceInterface[]
     */
    public function resources(): array;
}