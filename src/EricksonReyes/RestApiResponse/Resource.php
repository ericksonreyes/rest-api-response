<?php

namespace EricksonReyes\RestApiResponse;

use EricksonReyes\RestApiResponse\Exception\MissingResourceAttributesException;
use EricksonReyes\RestApiResponse\Exception\MissingResourceTypeException;
use EricksonReyes\RestApiResponse\Exception\MissingUniqueIdentifierException;

/**
 * Class Resource
 * @package EricksonReyes\RestApiResponse
 */
class Resource implements ResourceInterface
{
    /**
     * @var \EricksonReyes\RestApiResponse\LinksInterface|null
     */
    private ?LinksInterface $links = null;

    /**
     * @var array
     */
    private array $attributes = [];

    /**
     * @param string $id
     * @param string $type
     * @param array $attributes
     */
    public function __construct(
        private readonly string $id,
        private readonly string $type,
        array                   $attributes
    ) {
        if (trim($id) === '') {
            throw new MissingUniqueIdentifierException(
                'The required unique resource identifier is missing.'
            );
        }
        if (trim($type) === '') {
            throw new MissingResourceTypeException(
                'The required resource type is missing.'
            );
        }
        if (empty($attributes)) {
            throw new MissingResourceAttributesException(
                'The required resource attributes are missing.'
            );
        }

        foreach ($attributes as $field => $value) {
            if (strtolower($field) !== 'id') {
                $this->attributes[$field] = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return \EricksonReyes\RestApiResponse\LinksInterface|null
     */
    public function links(): ?LinksInterface
    {
        return $this->links;
    }

    /**
     * @param \EricksonReyes\RestApiResponse\LinksInterface $links
     * @return void
     */
    public function withLinks(LinksInterface $links): void
    {
        $this->links = $links;
    }
}
