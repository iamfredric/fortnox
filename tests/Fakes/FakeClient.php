<?php

namespace Iamfredric\Fortnox\Tests\Fakes;

use Iamfredric\Fortnox\Contracts\Request\ClientInterface;
use Iamfredric\Fortnox\Contracts\Request\ResponseInterface;

class FakeClient implements ClientInterface
{
    protected static array $responses = [];

    public function asJson(): static
    {
        // TODO: Implement asJson() method.

        return $this;
    }

    public function withHeaders(array $headers): static
    {
        // TODO: Implement withHeaders() method.

        return $this;
    }

    public function request(string $method, string $url, array $data = []): ResponseInterface
    {
        die(var_dump(self::$responses));
        return new FakeResponse(
            self::$responses[$method][$url] ?? null
        );
    }

    public static function when($method, $url, $data = [])
    {
        static::$responses[$method][$url] = $data;
    }
}