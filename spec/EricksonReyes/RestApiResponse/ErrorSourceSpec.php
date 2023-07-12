<?php

namespace spec\EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\ErrorSource;
use EricksonReyes\RestApiResponse\ErrorSourceType;
use PhpSpec\ObjectBehavior;

/**
 * Class ErrorSourceSpec
 * @package spec\EricksonReyes\RestApiResponse
 */
class ErrorSourceSpec extends ObjectBehavior
{

    public function let(): void
    {
        $this->beConstructedWith(
            ErrorSourceType::Pointer,
            'PASSWORD_FIELD'
        );
    }

    /**
     * @return void
     */
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ErrorSource::class);
    }

    /**
     * @return void
     */
    public function it_has_type(): void
    {
        $this->type()->shouldBeAnInstanceOf(ErrorSourceType::class);
    }

    /**
     * @return void
     */
    public function it_has_source(): void
    {
        $this->source()->shouldBeString();
    }
}
