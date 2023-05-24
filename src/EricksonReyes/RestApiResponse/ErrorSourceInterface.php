<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface ErrorSourceInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ErrorSourceInterface
{

    /**
     * Possible values.
     *
     * Input fields:
     * - field_name (Input field name where the error or validation error happened)
     *
     * Query parameters or filters:
     * - sort
     * - filter
     * - page
     * - limit
     * - offset
     *
     * Authentication-related parameters:
     * - Authorization
     * - Access-Token
     * - Bearer-Token
     *
     * API-specific parameters:
     * - resource_id
     * - relationship
     * - include
     * - fields
     *
     * File upload-related parameters:
     * - file
     * - file_name
     * - file_size
     *
     * @return string
     */
    public function parameter(): string;
}
