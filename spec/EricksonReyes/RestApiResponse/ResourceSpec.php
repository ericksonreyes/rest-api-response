<?php

namespace spec\EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\Exception\MissingResourceAttributesException;
use EricksonReyes\RestApiResponse\Exception\MissingResourceTypeException;
use EricksonReyes\RestApiResponse\Exception\MissingUniqueIdentifierException;
use EricksonReyes\RestApiResponse\Resource;
use EricksonReyes\RestApiResponse\ResourceInterface;
use spec\UnitTest;

/**
 * Class ResourceSpec
 * @package spec\EricksonReyes\RestApiResponse
 */
class ResourceSpec extends UnitTest
{
    /**
     * @var string
     */
    private string $expectedId;

    /**
     * @var string
     */
    private string $expectedType;

    /**
     * @var array
     */
    private array $expectedAttributes;

    public function let()
    {
        $this->beConstructedWith(
            $this->expectedId = $this->generator->uuid(),
            $this->expectedType = $this->generator->word(),
            $this->expectedAttributes = $this->generator->words()
        );
    }

    /**
     * @return void
     */
    public function it_can_be_initialized(): void
    {
        $this->shouldHaveType(Resource::class);
        $this->shouldImplement(ResourceInterface::class);
    }

    /**
     * @return void
     */
    public function it_has_a_resource_identifier(): void
    {
        $this->id()->shouldBeString();
        $this->id()->shouldReturn($this->expectedId);
    }

    /**
     * @return void
     */
    public function it_has_a_type(): void
    {
        $this->type()->shouldBeString();
        $this->type()->shouldReturn($this->expectedType);
    }

    /**
     * @return void
     */
    public function it_has_attributes(): void
    {
        $this->attributes()->shouldBeArray();
        $this->attributes()->shouldReturn($this->expectedAttributes);
    }

    /**
     * @return void
     */
    public function it_requires_a_resource_identifier(): void
    {
        $this->shouldThrow(MissingUniqueIdentifierException::class)
            ->during(
                '__construct',
                [
                    $this->randomEmptyString(),
                    $this->expectedType,
                    $this->expectedAttributes
                ]
            );
    }

    /**
     * @return void
     */
    public function it_requires_a_resource_type(): void
    {
        $this->shouldThrow(MissingResourceTypeException::class)
            ->during(
                '__construct',
                [
                    $this->expectedId,
                    $this->randomEmptyString(),
                    $this->expectedAttributes
                ]
            );
    }

    /**
     * @return void
     */
    public function it_requires_a_resource_attributes(): void
    {
        $this->shouldThrow(MissingResourceAttributesException::class)
            ->during(
                '__construct',
                [
                    $this->expectedId,
                    $this->expectedType,
                    []
                ]
            );
    }
}
