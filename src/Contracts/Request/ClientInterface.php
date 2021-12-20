<?php

namespace Iamfredric\Fortnox\Contracts\Request;

interface ClientInterface
{
    public function asJson(): static;

    /**
     * @param array<string, mixed> $headers
     * @return $this
     */
    public function withHeaders(array $headers): static;

    /**
     * @param string $method
     * @param string $url
     * @param array<string, mixed> $data
     * @return ResponseInterface
     */
    public function request(string $method, string $url, array $data = []): ResponseInterface;
}
