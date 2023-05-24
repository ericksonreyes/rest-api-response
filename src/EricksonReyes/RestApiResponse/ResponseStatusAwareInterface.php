<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface ResponseStatusAwareInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ResponseStatusAwareInterface
{

    /**
     * @return string
     */
    public function httpStatusCode(): string;

    /**
     * @return string
     */
    public function httpResponseDescription(): string;
}
