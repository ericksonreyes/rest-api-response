<?php

namespace spec\EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\Collection;
use EricksonReyes\RestApiResponse\ErrorInterface;
use EricksonReyes\RestApiResponse\Errors;
use PhpSpec\ObjectBehavior;

/**
 * Class ErrorsSpec
 * @package spec\EricksonReyes\RestApiResponse
 */
class ErrorsSpec extends ObjectBehavior
{
    /**
     * @return void
     */
    public function it_is_initializable():void
    {
        $this->shouldHaveType(Errors::class);
        $this->shouldHaveType(Collection::class);
    }

    /**
     * @param \EricksonReyes\RestApiResponse\ErrorInterface $error
     * @return void
     */
    public function it_collects_errors(ErrorInterface $error): void
    {
        $this->addError($error)->shouldBeNull();
        $this->errors()->shouldBeArray();

        $this->rewind()->shouldBeNull();
        $this->count()->shouldBeInt();
        $this->key()->shouldBeInt();
        $this->valid()->shouldBeBool();
        $this->next()->shouldBeNull();
        $this->current()->shouldBeNull();
    }

    /**
     * @param \EricksonReyes\RestApiResponse\ErrorInterface $error
     * @return void
     */
    public function it_knows_when_its_empty_or_not(ErrorInterface $error): void
    {
        $this->isEmpty()->shouldReturn(true);

        $this->addError($error)->shouldBeNull();
        $this->isEmpty()->shouldReturn(false);
    }
}
