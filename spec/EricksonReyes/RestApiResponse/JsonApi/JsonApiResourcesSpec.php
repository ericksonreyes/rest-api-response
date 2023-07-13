<?php

namespace spec\EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\JsonApi\JsonApiResources;
use PhpSpec\ObjectBehavior;

/**
 * Class JsonApiResourcesSpec
 * @package spec\EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiResourcesSpec extends ObjectBehavior
{

    /**
     * @return void
     */
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(JsonApiResources::class);
    }

    /**
     * @return void
     */
    public function it_has_name(): void
    {
        $this->name()->shouldBeString();
    }
}
