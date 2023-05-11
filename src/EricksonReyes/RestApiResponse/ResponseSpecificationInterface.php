<?php

namespace EricksonReyes\RestApiResponse;


/**
 * Interface ResponseSpecificationInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ResponseSpecificationInterface
{

    /**
     * @return string
     */
    public function specificationName(): string;

    /**
     * @return string
     */
    public function specificationVersion(): string;
}