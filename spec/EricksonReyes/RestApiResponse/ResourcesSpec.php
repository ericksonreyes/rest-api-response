<?php

namespace spec\EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\ErrorsInterface;
use EricksonReyes\RestApiResponse\LinksInterface;
use EricksonReyes\RestApiResponse\MetaInterface;
use EricksonReyes\RestApiResponse\ResourceInterface;
use EricksonReyes\RestApiResponse\Resources;
use PhpSpec\ObjectBehavior;

/**
 * Class ResourcesSpec
 * @package spec\EricksonReyes\RestApiResponse
 */
class ResourcesSpec extends ObjectBehavior
{
    /**
     * @return void
     */
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Resources::class);
    }

    /**
     * @param \EricksonReyes\RestApiResponse\ResourceInterface $resource
     * @return void
     */
    public function it_can_have_resources(ResourceInterface $resource): void
    {
        $this->addResource($resource)->shouldBeNull();
        $this->data()->shouldHaveCount(1);
    }

    /**
     * @param \EricksonReyes\RestApiResponse\LinksInterface $links
     * @return void
     */
    public function it_can_have_links(LinksInterface $links): void
    {
        $this->withLinks($links)->shouldBeNull();
        $this->links()->shouldReturn($links);
    }

    /**
     * @param \EricksonReyes\RestApiResponse\MetaInterface $meta
     * @return void
     */
    public function it_can_have_metadata(MetaInterface $meta): void
    {
        $this->withMeta($meta)->shouldBeNull();
        $this->meta()->shouldReturn($meta);
    }

    /**
     * @param \EricksonReyes\RestApiResponse\ErrorsInterface $errors
     * @return void
     */
    public function it_can_have_errors(ErrorsInterface $errors): void
    {
        $this->withErrors($errors)->shouldBeNull();
        $this->errors()->shouldReturn($errors);
    }

    /**
     * @return void
     */
    public function it_can_have_dynamic_number_of_records(): void
    {
        $this->setTotalNumberOfRecords(100)->shouldBeNull();
        $this->numberOfRecords()->shouldReturn(100);
    }

    /**
     * @return void
     */
    public function it_can_have_pagination(): void
    {
        $this->withPagination(
            numberOfRecords: 100,
            recordsPerPage: 10,
            currentPageNumber: 100
        )->shouldBeNull();

        $this->withPagination(
            numberOfRecords: 100,
            recordsPerPage: 10,
            currentPageNumber: 0
        )->shouldBeNull();

        $this->recordsPerPage()->shouldBeInt();
        $this->currentPageNumber()->shouldBeInt();

        $this->firstPage()->shouldBeInt();
        $this->nextPage()->shouldBeInt();
        $this->previousPage()->shouldBeInt();
        $this->lastPage()->shouldBeInt();
    }

    /**
     * @return void
     */
    public function it_can_have_a_base_url(): void
    {
        $this->setBaseUrl('http://www.example.com');
        $this->baseUrl()->shouldBeString();
    }
}
