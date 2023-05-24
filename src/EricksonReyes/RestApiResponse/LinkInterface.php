<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface LinkInterface
 * @package EricksonReyes\RestApiResponse
 */
interface LinkInterface
{

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function url(): string;
}
