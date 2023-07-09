<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface ErrorSourceInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ErrorSourceInterface
{


    /**
     * @return \EricksonReyes\RestApiResponse\ErrorSourceType
     */
    public function type(): ErrorSourceType;

    /**
     * @return string
     */
    public function source(): string;


}
