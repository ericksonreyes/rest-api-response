<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface ResourceInterface
 * @package EricksonReyes\RestApiResponse
 */
interface ResourceInterface
{
    /**
     * @return mixed
     */
    public function id(): string;

    /**
     * @return string
     */
    public function type(): string;

    /**
     * @return array
     */
    public function attributes(): array;

    /**
     * @return \EricksonReyes\RestApiResponse\LinksInterface|null
     */
    public function links(): ?LinksInterface;
}
