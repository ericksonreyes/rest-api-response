<?php

namespace EricksonReyes\RestApiResponse;

use Countable;
use Iterator;

/**
 * Class Collection
 * @package EricksonReyes\RestApiResponse
 */
abstract class Collection implements Iterator, Countable
{
    /**
     * @var int
     */
    private int $position = 0;

    /**
     * @var array
     */
    protected array $items = [];

    /**
     * @var int
     */
    private int $count = 0;

    public function __construct()
    {
        $this->position = 0;
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->items[$this->position];
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->count;
    }


    /**
     * @return array
     */
    protected function items(): array
    {
        return $this->items;
    }

    /**
     * @param mixed $item
     * @return void
     */
    protected function addItem(mixed $item): void
    {
        $this->items[] = $item;
        $this->count++;
    }
}
