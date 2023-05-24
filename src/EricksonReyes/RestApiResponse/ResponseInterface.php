<?php

namespace EricksonReyes\RestApiResponse;

use \EricksonReyes\RestApiResponse\ResponseStatusAwareInterface as StatusAware;
use \EricksonReyes\RestApiResponse\ResponseMediaTypeAwareInterface as MediaAware;
use \EricksonReyes\RestApiResponse\ResponseSpecificationInterface as SpecificationAware;

/**
 * Interface ResponseInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ResponseInterface extends StatusAware, MediaAware, SpecificationAware
{

    /**
     * @return array
     */
    public function array(): array;

    /**
     * @return string
     */
    public function __toString(): string;
}
