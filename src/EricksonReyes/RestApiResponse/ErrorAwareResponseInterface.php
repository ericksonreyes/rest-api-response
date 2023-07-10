<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface ErrorAwareResponseInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ErrorAwareResponseInterface
{

    /**
     * @return \EricksonReyes\RestApiResponse\ErrorsInterface
     */
    public function errors(): ErrorsInterface;

    /**
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * @return bool
     */
    public function hasNoErrors(): bool;
}
