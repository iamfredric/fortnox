<?php

namespace Iamfredric\Fortnox\Contracts;

use DateTime;

interface Authenticatable
{
    public function getFortnoxAccessToken(): string;

    public function getFortnoxRefreshToken(): string;

    public function getFortnoxExpiresAt(): DateTime;

    /**
     * @param array<string, mixed> $data
     *
     * @return void
     */
    public function onFortnoxUpdate($data): void;
}
