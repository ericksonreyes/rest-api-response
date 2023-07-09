<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Class ErrorSource
 * @package EricksonReyes\RestApiResponse
 */
class ErrorSource implements ErrorSourceInterface
{

    /**
     * @param \EricksonReyes\RestApiResponse\ErrorSourceType $type
     * @param string $source
     */
    public function __construct(private readonly ErrorSourceType $type, private readonly string $source)
    {
    }

    /**
     * @return \EricksonReyes\RestApiResponse\ErrorSourceType
     */
    public function type(): ErrorSourceType
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function source(): string
    {
        return $this->source;
    }


}