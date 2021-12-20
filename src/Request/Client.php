<?php

namespace Iamfredric\Fortnox\Request;

use Iamfredric\Fortnox\Contracts\Request\ClientInterface;
use Iamfredric\Fortnox\Contracts\Request\ResponseInterface;

class Client implements ClientInterface
{
    /**
     * @var array<string, string>
     */
    protected array $headers = [];

    protected string $bodyFormat = 'form_params';

    public function __construct(
        protected \GuzzleHttp\Client $client
    ) {
    }

    public function asJson(): static
    {
        $this->headers['Accept'] = 'application/json';
        $this->bodyFormat = 'json';

        return $this;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array<string, mixed> $data
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, string $url, array $data = []): ResponseInterface
    {
        $response = $this->client->request($method, $url, [
            'headers' => $this->headers,
            $this->bodyFormat => $data
        ]);

        return new Response($response);
    }

    /**
     * @param array<string, string> $headers
     * @return $this
     */
    public function withHeaders(array $headers): static
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }
}
