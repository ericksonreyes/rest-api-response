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
    public function responseCode(): string;

    /**
     * @return string
     */
    public function responseDescription(): string;
}