<?php

namespace spec\EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\Exception\MissingNameException;
use EricksonReyes\RestApiResponse\Exception\MissingUrlException;
use EricksonReyes\RestApiResponse\Link;
use EricksonReyes\RestApiResponse\LinkInterface;
use spec\UnitTest;

/**
 * Class LinkSpec
 * @package spec\EricksonReyes\RestApiResponse
 */
class LinkSpec extends UnitTest
{

    /**
     * @var string
     */
    private string $expectedName = '';

    /**
     * @var string
     */
    private string $expectedUrl = '';

    /**
     * @return void
     */
    public function let(): void
    {
        $this->beConstructedWith(
            $this->expectedName = $this->generator->word(),
            $this->expectedUrl = $this->generator->url()
        );
    }

    /**
     * @return void
     */
    public function it_can_be_initialized(): void
    {
        $this->shouldHaveType(Link::class);
        $this->shouldHaveType(LinkInterface::class);
    }

    /**
     * @return void
     */
    public function it_has_a_name(): void
    {
        $this->name()->shouldBeString();
        $this->name()->shouldReturn($this->expectedName);
    }

    /**
     * @return void
     */
    public function it_has_a_url(): void
    {
        $this->url()->shouldBeString();
        $this->url()->shouldReturn($this->expectedUrl);
    }

    /**
     * @return void
     */
    public function it_requires_a_link_name(): void
    {
        $this->shouldThrow(
            MissingNameException::class
        )->during(
            '__construct',
            [
                $this->randomEmptyString(),
                $this->expectedUrl
            ]
        );
    }

    /**
     * @return void
     */
    public function it_requires_a_link_url(): void
    {
        $this->shouldThrow(
            MissingUrlException::class
        )->during(
            '__construct',
            [
                $this->expectedName,
                $this->randomEmptyString()
            ]
        );
    }
}
