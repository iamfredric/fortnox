<?php

namespace Iamfredric\Fortnox\Tests\Fakes;

use Iamfredric\Fortnox\Contracts\Request\ResponseInterface;

class FakeResponse implements ResponseInterface
{
    public function __construct(
        protected $data
    ) {}

    public function status(): int
    {
        return 200;
    }

    public function json(): array
    {
        return $this->data;
    }

    public function body(): mixed
    {
        return 'Todo';
    }
}