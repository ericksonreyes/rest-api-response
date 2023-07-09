<?php

namespace EricksonReyes\RestApiResponse;

use Countable;
use Iterator;

/**
 * Interface ErrorsInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ErrorsInterface extends Iterator, Countable
{

    /**
     * @return \EricksonReyes\RestApiResponse\ErrorsInterface[]
     */
    public function errors(): array;

    /**
     * @return bool
     */
    public function isEmpty(): bool;
    
    /**
     * @return bool
     */
    public function isNotEmpty(): bool;
}
