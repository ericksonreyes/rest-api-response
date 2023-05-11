<?php

namespace EricksonReyes\RestApiResponse;


/**
 * Interface ResponseMediaTypeAwareInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ResponseMediaTypeAwareInterface
{
    /**
     * @return string
     */
    public function mediaType(): string;
}