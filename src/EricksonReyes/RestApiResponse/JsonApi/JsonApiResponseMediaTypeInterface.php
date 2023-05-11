<?php

namespace EricksonReyes\RestApiResponse\JsonApi;


use EricksonReyes\RestApiResponse\ResponseMediaTypeAwareInterface;

/**
 * Interface JsonApiResponseMediaTypeInterface
 * @package EricksonReyes\RestApiResponse\JsonApi
 */
interface JsonApiResponseMediaTypeInterface extends ResponseMediaTypeAwareInterface
{

    public const RESPONSE_MEDIA_TYPE_JSON_API = 'application/vnd.api+json';
}