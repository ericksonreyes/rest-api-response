<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Class Resources
 * @package EricksonReyes\RestApiResponse
 */
class Resources extends Collection implements ResourcesInterface, ResponseStatusAware
{
    /**
     * @var \EricksonReyes\RestApiResponse\LinksInterface|null
     */
    private ?LinksInterface $links;

    /**
     * @var \EricksonReyes\RestApiResponse\MetaInterface|null
     */
    private ?MetaInterface $meta;

    /**
     * @var \EricksonReyes\RestApiResponse\ErrorsInterface|null
     */
    private ?ErrorsInterface $errors;

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

}
