<?php

namespace spec\EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\Collection;
use EricksonReyes\RestApiResponse\ErrorInterface;
use EricksonReyes\RestApiResponse\LinkInterface;
use EricksonReyes\RestApiResponse\Links;
use EricksonReyes\RestApiResponse\LinksInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class LinksSpec
 * @package spec\EricksonReyes\RestApiResponse
 */
class LinksSpec extends ObjectBehavior
{
    /**
     * @return void
     */
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Links::class);
        $this->shouldHaveType(Collection::class);
    }

    /**
     * @param \EricksonReyes\RestApiResponse\LinkInterface $link
     * @return void
     */
    public function it_collects_links(LinkInterface $link): void
    {
        $this->addLink($link)->shouldBeNull();
        $this->links()->shouldBeArray();

        $this->rewind()->shouldBeNull();
        $this->count()->shouldBeInt();
        $this->key()->shouldBeInt();
        $this->valid()->shouldBeBool();
        $this->next()->shouldBeNull();
        $this->current()->shouldBeNull();
    }
}
