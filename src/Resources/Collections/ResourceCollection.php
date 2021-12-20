<?php

namespace Iamfredric\Fortnox\Resources\Collections;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class ResourceCollection implements IteratorAggregate, Countable
{
    /**
     * @var array<mixed>
     */
    protected array $data = [];

    /**
     * @param array<mixed> $attributes
     * @param string $resourceKey
     * @param string $resourceClass
     */
    public function __construct(
        protected array $attributes,
        protected string $resourceKey,
        protected string $resourceClass
    ) {
        if (isset($this->attributes[$this->resourceKey])) {
            $this->data = array_map(
                fn ($resource) => new $this->resourceClass($resource),
                $this->attributes[$this->resourceKey]
            );
            unset($this->attributes[$this->resourceKey]);
        }
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }

    /**
     * @return array<Resource>
     */
    public function toArray(): array
    {
        return array_map(fn ($resource) => $resource->toArray(), $this->data);
    }

    public function __toString(): string
    {
        return json_encode($this->data) ?: '';
    }

    public function count(): int
    {
        return count($this->data);
    }
}
