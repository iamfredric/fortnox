<?php

namespace Iamfredric\Fortnox\Exceptions;

use Exception;

class AuthFailureException extends Exception
{
    public static function refreskTokenNotFound(): AuthFailureException
    {
        return new self('Refresh token not found.');
    }

    public static function failedToRefreshToken(): AuthFailureException
    {
        return new self('Could not refresh token.');
    }
}
