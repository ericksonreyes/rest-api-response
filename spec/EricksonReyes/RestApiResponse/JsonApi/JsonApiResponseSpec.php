<?php

namespace spec\EricksonReyes\RestApiResponse\JsonApi;

use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponse;
use EricksonReyes\RestApiResponse\JsonApi\JsonApiResponseInterface;
use EricksonReyes\RestApiResponse\ResponseInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class JsonApiResponseSpec
 * @package spec\EricksonReyes\RestApiResponse\JsonApi
 */
class JsonApiResponseSpec extends ObjectBehavior
{

    /**
     * @return void
     */
    public function it_can_be_initialized(): void
    {
        $this->shouldHaveType(JsonApiResponse::class);
        $this->shouldImplement(JsonApiResponseInterface::class);
        $this->shouldImplement(ResponseInterface::class);
    }
}
