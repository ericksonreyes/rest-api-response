<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface PaginatedResourcesInterface
 * @package EricksonReyes\RestApiResponse
 */
interface PaginatedResourcesInterface
{

    /**
     * @return int
     */
    public function numberOfRecords(): int;

    /**
     * @return int
     */
    public function recordsPerPage(): int;

    /**
     * @return int
     */
    public function currentPageNumber(): int;

    /**
     * @return int
     */
    public function numberOfPages(): int;

    /**
     * @return int
     */
    public function firstPage(): int;

    /**
     * @return int
     */
    public function nextPage(): int;

    /**
     * @return int
     */
    public function previousPage(): int;

    /**
     * @return int
     */
    public function lastPage(): int;
}
