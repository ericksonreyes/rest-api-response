<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface HttpResponseStatusCodeAwareInterface
 * @package EricksonReyes\RestApiResponse
 */
interface HttpResponseStatusCodeAwareInterface
{
    /**
     * @return int
     */
    public function httpStatusCode(): int;
}
