<?php

namespace spec\EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\Error;
use EricksonReyes\RestApiResponse\ErrorSourceInterface;
use Faker\Factory;
use PhpSpec\ObjectBehavior;

/**
 * Class ErrorSpec
 * @package spec\EricksonReyes\RestApiResponse
 */
class ErrorSpec extends ObjectBehavior
{

    public function let(): void
    {
        $this->beConstructedWith(200, 'Hello World.');
    }

    /**
     * @return void
     */
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Error::class);
    }

    /**
     * @return void
     */
    public function it_has_http_status_code(): void
    {
        $this->httpStatusCode()->shouldBeInt();
    }

    /**
     * @return void
     */
    public function it_has_title(): void
    {
        $this->title()->shouldBeString();
    }

    /**
     * @return void
     */
    public function it_can_have_an_error_code(): void
    {
        $this->withCode('INVALID_PASSWORD')->shouldBeNull();
        $this->code()->shouldBeString();
    }

    /**
     * @return void
     */
    public function it_can_have_details(): void
    {
        $this->withDetail('Invalid password.')->shouldBeNull();
        $this->detail()->shouldBeString();
    }

    /**
     * @return void
     */
    public function it_can_have_error_source(ErrorSourceInterface $errorSource): void
    {
        $this->fromSource($errorSource)->shouldBeNull();
        $this->source()->shouldBeAnInstanceOf(ErrorSourceInterface::class);
    }
}
