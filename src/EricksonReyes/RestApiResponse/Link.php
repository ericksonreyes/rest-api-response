<?php

namespace EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\Exception\MissingNameException;
use EricksonReyes\RestApiResponse\Exception\MissingUrlException;

/**
 * Class Link
 * @package EricksonReyes\RestApiResponse
 */
class Link implements LinkInterface
{
    /**
     * @param string $name
     * @param string $url
     */
    public function __construct(
        private readonly string $name,
        private readonly string $url
    ) {
        if (trim($name) === '') {
            throw new MissingNameException("The required link name is missing.");
        }
        if (trim($url) === '') {
            throw new MissingUrlException("The required link URL is missing.");
        }
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }
}
