<?php

namespace Iamfredric\Fortnox\Tests\Fakes;

use DateTime;
use Iamfredric\Fortnox\Contracts\Authenticatable;

class AuthenticatableFake implements Authenticatable
{
    public bool $refreshTokenCalled = false;

    public function getFortnoxAccessToken(): string
    {
        return 'access_token';
    }

    public function getFortnoxRefreshToken(): string
    {
        return 'refresh_token';
    }

    public function getFortnoxExpiresAt(): DateTime
    {
        return new DateTime('+1 hour');
    }

    public function onFortnoxUpdate($data): void
    {
        $this->refreshTokenCalled = true;
    }
}