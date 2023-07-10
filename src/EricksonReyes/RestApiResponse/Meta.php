<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Class Meta
 * @package EricksonReyes\RestApiResponse
 */
class Meta extends Collection implements MetaInterface
{

    /**
     * @param int|string $key
     * @param mixed $value
     * @return void
     */
    public function addMetaData(int|string $key, mixed $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * @return array
     */
    public function meta(): array
    {
        return $this->items();
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->isNotEmpty() === false;
    }

    /**
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return count($this->items()) > 0;
    }
}
