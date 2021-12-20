<?php

namespace Iamfredric\Fortnox;

use Iamfredric\Fortnox\Contracts\Authenticatable;
use Iamfredric\Fortnox\Contracts\Request\ClientInterface;
use Iamfredric\Fortnox\Exceptions\AuthenticatableNotSetException;
use Iamfredric\Fortnox\Exceptions\AuthFailureException;
use Iamfredric\Fortnox\Request\Client;

class Fortnox
{
    const AUTH_URL = 'https://apps.fortnox.se/oauth-v1/auth';

    protected static ?ClientInterface $httpClient = null;

    public static ?string $clientId;

    public static ?string $clientSecret;

    public static ?string $redirectUrl;

    public static ?string $scope;

    public static ?Authenticatable $authenticatable;

    public static function setClientCredentials(
        string $clientId,
        string $clientSecret,
        string $redirectUrl,
        string $scope
    ): void {
        self::$clientId = $clientId;
        self::$clientSecret = $clientSecret;
        self::$redirectUrl = $redirectUrl;
        self::$scope = $scope;
    }

    public static function authenticateAs(Authenticatable $authenticatable): void
    {
        self::$authenticatable = $authenticatable;
    }

    public static function authUrl(): string
    {
        return self::AUTH_URL . '?'.http_build_query([
            'client_id' => self::$clientId,
            'redirect_url' => self::$redirectUrl,
            'scope' => self::$scope,
            'response_type' => 'code',
            'state' => 'offline'
        ]);
    }

    /**
     * @param string $code
     * @return array<string, string>
     */
    public static function verifyAuthCode(string $code): array
    {
        $response = self::getHttpClient()
            ->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic '.self::basicCredentials()
            ])
            ->request('POST', 'https://apps.fortnox.se/oauth-v1/token', [
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => self::$redirectUrl
            ]);

        return $response->json();
    }

    protected static function basicCredentials(): string
    {
        return base64_encode(self::$clientId.':'.self::$clientSecret);
    }

    public static function refreshToken(): void
    {
        if (empty(self::$authenticatable?->getFortnoxRefreshToken())) {
            throw AuthFailureException::refreskTokenNotFound();
        }

        $response = static::getHttpClient()
            ->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic '.self::basicCredentials()
            ])
            ->request('POST', 'https://apps.fortnox.se/oauth-v1/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => self::$authenticatable->getFortnoxRefreshToken()
            ]);

        if ($response->status() >= 200 && $response->status() <= 300) {
            self::$authenticatable->onFortnoxUpdate($response->json());
        } else {
            throw AuthFailureException::failedToRefreshToken();
        }
    }

    /**
     * @param string $method
     * @param string $url
     * @param array<string, mixed> $data
     * @return array<mixed>
     * @throws AuthFailureException
     * @throws AuthenticatableNotSetException
     */
    public static function request(string $method, string $url, array $data = []): array
    {
        if (! static::$authenticatable) {
            throw new AuthenticatableNotSetException(
                "The authenticatable class has not been set. Please set it via authenticateAs method."
            );
        }

        if (self::tokenHasExpired()) {
            self::refreshToken();
        }

        $response = self::getHttpClient()
            ->asJson()
            ->withHeaders([
                'Authorization' => 'Bearer '.Fortnox::$authenticatable?->getFortnoxAccessToken(),
                'Client-Secret' => Fortnox::$clientSecret,
            ])
            ->request($method, $url, $data);

        return $response->json();
    }

    protected static function tokenHasExpired(): bool
    {
        return self::$authenticatable?->getFortnoxExpiresAt()->getTimestamp() < time();
    }

    protected static function getHttpClient(): ClientInterface
    {
        return static::$httpClient ?: new Client(new \GuzzleHttp\Client());
    }

    public static function setHttpClient(ClientInterface $client): void
    {
        static::$httpClient = $client;
    }
}
