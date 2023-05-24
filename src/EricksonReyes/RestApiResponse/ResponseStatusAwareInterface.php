<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface ResponseStatusAwareInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ResponseStatusAwareInterface
{

    /**
     * @return int
     */
    public function httpStatusCode(): int;

    /**
     * @return string
     */
    public function httpResponseDescription(): string;
}
