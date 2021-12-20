<?php

namespace Iamfredric\Fortnox\Contracts\Request;

interface ResponseInterface
{
    public function status(): int;

    /**
     * @return array<mixed>
     */
    public function json(): array;

    public function body(): mixed;
}
