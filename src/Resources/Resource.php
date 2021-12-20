<?php

namespace Iamfredric\Fortnox\Resources;

use Iamfredric\Fortnox\Fortnox;
use Iamfredric\Fortnox\Resources\Collections\ResourceCollection;
use ReflectionClass;

abstract class Resource
{
    /**
     * @param array<mixed> $attributes
     */
    final public function __construct(
        protected array $attributes = []
    ) {
    }

    protected static function getResourceKey(): string
    {
        return (new ReflectionClass(static::class))
            ->getShortName();
    }

    protected static function getResourceKeyAsPluralized(): string
    {
        return (new ReflectionClass(static::class))
            ->getShortName() . 's';
    }

    /**
     * @return ResourceCollection<Resource>
     * @throws \Iamfredric\Fortnox\Exceptions\AuthenticatableNotSetException
     */
    public static function all(): ResourceCollection
    {
        return new ResourceCollection(
            Fortnox::request('GET', self::getUrl()),
            self::getResourceKeyAsPluralized(),
            static::class
        );
    }

    public static function find(int $id): static
    {
        $response = Fortnox::request('GET', self::getUrl($id));

        return new static($response[self::getResourceKey()]);
    }

    /**
     * @param array<string, mixed> $data
     * @return Resource
     * @throws \Iamfredric\Fortnox\Exceptions\AuthenticatableNotSetException
     */
    public static function create(array $data): Resource
    {
        $response = Fortnox::request('POST', self::getUrl(), [
            'json' => [
                self::getResourceKey() => $data
            ]
        ]);

        return new static($response[self::getResourceKey()]);
    }

    /**
     * @param array<mixed> $data
     * @return $this
     * @throws \Iamfredric\Fortnox\Exceptions\AuthenticatableNotSetException
     */
    public function update(array $data): Resource
    {
        $response = Fortnox::request('PUT', self::getUrl($this->attributes[$this->getIdKey()]), [
            'json' => [
                self::getResourceKey() => $data
            ]
        ]);

        $this->attributes = $response[self::getResourceKey()];

        return $this;
    }

    public function save(): static
    {
        Fortnox::request('PUT', self::getUrl($this->attributes[$this->getIdKey()]), [
            'json' => [
                self::getResourceKey() => $this->attributes
            ]
        ]);

        return $this;
    }

    /**
     * @return array<mixed>
     * @throws \Iamfredric\Fortnox\Exceptions\AuthenticatableNotSetException
     */
    public function delete(): array
    {
        return Fortnox::request('DELETE', self::getUrl($this->attributes[$this->getIdKey()]));
    }

    abstract protected function getIdKey(): string;

    protected static function getBaseUrl(): string
    {
        return 'https://api.fortnox.se/3';
    }

    public static function getUrl(mixed $uri = null): string
    {
        return trim(implode('/', [
            self::getBaseUrl(),
            strtolower(self::getResourceKeyAsPluralized()),
            $uri
        ]), '/');
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    public function __get(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }
}
