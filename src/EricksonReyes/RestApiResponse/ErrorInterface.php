<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface ErrorInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ErrorInterface
{

    /**
     * @return int
     */
    public function status(): int;

    /**
     * @return string
     */
    public function code(): string;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return string
     */
    public function detail(): string;

    /**
     * @return \EricksonReyes\RestApiResponse\ErrorSourceInterface|null
     */
    public function source(): ?ErrorSourceInterface;
}
