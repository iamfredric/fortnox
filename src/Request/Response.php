<?php

namespace Iamfredric\Fortnox\Request;

use Iamfredric\Fortnox\Contracts\Request\ResponseInterface as Responsible;
use Psr\Http\Message\ResponseInterface;

class Response implements Responsible
{
    public function __construct(
        protected ResponseInterface $response
    ) {
    }

    public function status(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return array<mixed>
     */
    public function json(): array
    {
        return json_decode(
            (string) $this->response->getBody(),
            true
        );
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    public function body(): mixed
    {
        return $this->response->getBody();
    }
}
