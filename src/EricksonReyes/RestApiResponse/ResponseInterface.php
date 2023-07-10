<?php

namespace EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\ErrorAwareResponseInterface as ErrorAware;
use EricksonReyes\RestApiResponse\ResponseMediaTypeAwareInterface as MediaAware;
use EricksonReyes\RestApiResponse\ResponseSpecificationInterface as SpecificationAware;
use EricksonReyes\RestApiResponse\ResponseStatusAwareInterface as StatusAware;

/**
 * Interface ResponseInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ResponseInterface extends ErrorAware, StatusAware, MediaAware, SpecificationAware
{

    /**
     * @return \EricksonReyes\RestApiResponse\ResourcesInterface
     */
    public function resources(): ResourcesInterface;

    /**
     * @return bool
     */
    public function hasResources(): bool;

    /**
     * @return bool
     */
    public function hasNoResources(): bool;

    /**
     * @return array
     */
    public function array(): array;

    /**
     * @return string
     */
    public function __toString(): string;
}
