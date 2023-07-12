<?php

namespace spec\EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\Collection;
use EricksonReyes\RestApiResponse\Meta;
use PhpSpec\ObjectBehavior;

/**
 * Class MetaSpec
 * @package spec\EricksonReyes\RestApiResponse
 */
class MetaSpec extends ObjectBehavior
{
    /**
     * @return void
     */
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Meta::class);
        $this->shouldHaveType(Collection::class);
    }

    /**
     * @return void
     */
    public function it_collects_metadata(): void
    {
        $this->addMetaData(key: 'author', value: 'Erickson Reyes')->shouldBeNull();
        $this->meta()->shouldBeArray();
    }

    /**
     * @return void
     */
    public function it_knows_when_its_empty_or_not(): void
    {
        $this->isEmpty()->shouldReturn(true);

        $this->addMetaData(key: 'author', value: 'Erickson Reyes');
        $this->isEmpty()->shouldReturn(false);
    }
}
