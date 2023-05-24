<?php

namespace EricksonReyes\RestApiResponse;

use Countable;
use Iterator;

/**
 * Interface ResourcesInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ResourcesInterface extends Iterator, Countable
{

    /**
     * @return \EricksonReyes\RestApiResponse\ResourceInterface[]
     */
    public function data(): array;

    /**
     * @return \EricksonReyes\RestApiResponse\LinksInterface
     */
    public function links(): LinksInterface;

    /**
     * @return \EricksonReyes\RestApiResponse\MetaInterface
     */
    public function meta(): MetaInterface;

    /**
     * @return \EricksonReyes\RestApiResponse\ErrorsInterface
     */
    public function errors(): ErrorsInterface;
}
