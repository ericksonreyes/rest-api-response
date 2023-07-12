<?php

namespace EricksonReyes\RestApiResponse;

enum ErrorSourceType
{
    case Header;

    case Parameter;

    case Pointer;
    
    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function name(): string
    {
        return match ($this) {
            ErrorSourceType::Header => 'header',
            ErrorSourceType::Parameter => 'parameter',
            ErrorSourceType::Pointer => 'pointer',
        };
    }
}
