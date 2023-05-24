<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Class Resources
 * @package EricksonReyes\RestApiResponse
 */
class Resources extends Collection implements ResourcesInterface
{
    /**
     * @var \EricksonReyes\RestApiResponse\LinksInterface
     */
    private LinksInterface $links;

    /**
     * @var \EricksonReyes\RestApiResponse\MetaInterface
     */
    private MetaInterface $meta;

    /**
     * @var \EricksonReyes\RestApiResponse\ErrorsInterface
     */
    private ErrorsInterface $errors;

    /**
     * @var int
     */
    private int $numberOfRecords = 0;

    /**
     * @var int
     */
    private int $recordsPerPage = 0;

    /**
     * @var int
     */
    private int $currentPageNumber = 0;

    /**
     * @var int
     */
    private int $numberOfPages = 0;

    /**
     * @var int
     */
    private int $firstPage = 0;

    /**
     * @var int
     */
    private int $nextPage = 0;

    /**
     * @var int
     */
    private int $previousPage = 0;

    /**
     * @var int
     */
    private int $lastPage = 0;

    /**
     * @var string
     */
    private string $baseUrl = '';

    public function __construct()
    {
        $this->links = new Links();
        $this->meta = new Meta();
        $this->errors = new Errors();
    }

    /**
     * @param \EricksonReyes\RestApiResponse\ResourceInterface $resource
     * @return void
     */
    public function addResource(ResourceInterface $resource): void
    {
        $this->addItem($resource);
    }

    /**
     * @return \EricksonReyes\RestApiResponse\ResourceInterface[]
     */
    public function data(): array
    {
        return $this->items();
    }


    /**
     * @param \EricksonReyes\RestApiResponse\LinksInterface $links
     * @return void
     */
    public function withLinks(LinksInterface $links): void
    {
        $this->links = $links;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\LinksInterface
     */
    public function links(): LinksInterface
    {
        return $this->links;
    }

    /**
     * @param \EricksonReyes\RestApiResponse\MetaInterface $meta
     * @return void
     */
    public function withMeta(MetaInterface $meta): void
    {
        $this->meta = $meta;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\MetaInterface
     */
    public function meta(): MetaInterface
    {
        return $this->meta;
    }


    /**
     * @param \EricksonReyes\RestApiResponse\ErrorsInterface $errors
     * @return void
     */
    public function withErrors(ErrorsInterface $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\ErrorsInterface
     */
    public function errors(): ErrorsInterface
    {
        return $this->errors;
    }

    /**
     * @param int $numberOfRecords
     * @return void
     */
    public function setTotalNumberOfRecords(int $numberOfRecords): void
    {
        $this->numberOfRecords = $numberOfRecords;
    }

    /**
     * @param int $numberOfRecords
     * @param int $recordsPerPage
     * @param int $currentPageNumber
     * @return void
     */
    public function withPagination(int $numberOfRecords, int $recordsPerPage, int $currentPageNumber = 1): void
    {
        $this->numberOfRecords = $numberOfRecords;
        $this->recordsPerPage = $recordsPerPage;
        $this->currentPageNumber = $currentPageNumber;

        $this->calculatePagination();
    }

    /**
     * @return void
     */
    private function calculatePagination(): void
    {
        if ($this->numberOfRecords() > 0 && $this->recordsPerPage() > 0) {
            $this->numberOfPages = intval($this->numberOfRecords() / $this->recordsPerPage());
            $this->firstPage = 1;
            $this->lastPage = $this->numberOfPages();
            $this->nextPage = $this->currentPageNumber() + 1;
            $this->previousPage = $this->currentPageNumber() - 1;

            if ($this->nextPage() > $this->lastPage()) {
                $this->nextPage = 0;
            }
            if ($this->previousPage() < 0) {
                $this->previousPage = 0;
            }
        }
    }


    /**
     * @return int
     */
    public function numberOfRecords(): int
    {
        return $this->numberOfRecords;
    }

    /**
     * @return int
     */
    public function recordsPerPage(): int
    {
        return $this->recordsPerPage;
    }

    /**
     * @return int
     */
    public function currentPageNumber(): int
    {
        return $this->currentPageNumber;
    }

    /**
     * @return int
     */
    public function numberOfPages(): int
    {
        return $this->numberOfPages;
    }

    /**
     * @return int
     */
    public function firstPage(): int
    {
        return $this->firstPage;
    }

    /**
     * @return int
     */
    public function nextPage(): int
    {
        return $this->nextPage;
    }

    /**
     * @return int
     */
    public function previousPage(): int
    {
        return $this->previousPage;
    }

    /**
     * @return int
     */
    public function lastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * @param string $baseUrl
     * @return void
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function baseUrl(): string
    {
        return $this->baseUrl;
    }
}
