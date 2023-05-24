<?php

namespace EricksonReyes\RestApiResponse;

use Countable;
use Iterator;

/**
 * Interface MetaInterface
 * @package EricksonReyes\RestApiResponse
 */
interface MetaInterface extends Iterator, Countable
{

    /**
     * @return array
     */
    public function meta(): array;
}
