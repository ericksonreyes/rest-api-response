<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Class Error
 * @package EricksonReyes\RestApiResponse
 */
class Error implements ErrorInterface
{

    /**
     * @var string
     */
    private string $code = '';

    /**
     * @var string
     */
    private string $detail = '';

    /**
     * @var \EricksonReyes\RestApiResponse\ErrorSourceInterface|null
     */
    private ?ErrorSourceInterface $source = null;


    /**
     * @param int $status
     * @param string $title
     */
    public function __construct(
        private readonly int    $status,
        private readonly string $title
    ) {
    }

    /**
     * @return int
     */
    public function status(): int
    {
        return $this->status;
    }


    /**
     * @param string $code
     * @return void
     */
    public function withCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @param string $detail
     * @return void
     */
    public function withDetail(string $detail): void
    {
        $this->detail = $detail;
    }

    /**
     * @return string
     */
    public function detail(): string
    {
        return $this->detail;
    }

    /**
     * @param \EricksonReyes\RestApiResponse\ErrorSourceInterface $source
     * @return void
     */
    public function fromSource(ErrorSourceInterface $source): void
    {
        $this->source = $source;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\ErrorSourceInterface|null
     */
    public function source(): ?ErrorSourceInterface
    {
        return $this->source;
    }
}
