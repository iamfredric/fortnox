<?php

namespace Iamfredric\Fortnox\Tests\Unit;

use Iamfredric\Fortnox\Fortnox;
use Iamfredric\Fortnox\Tests\Fakes\AuthenticatableFake;
use Iamfredric\Fortnox\Tests\Fakes\FakeClient;
use Iamfredric\Fortnox\Tests\TestCase;

class AuthorizationsTest extends TestCase
{
    /** @test */
    function it_generates_auth_url()
    {
        $this->assertEquals(
            'https://apps.fortnox.se/oauth-v1/auth?client_id=test_client&redirect_url=https%3A%2F%2Fexample.com%2Fcallback&scope=test&response_type=code&state=offline',
            Fortnox::authUrl()
        );
    }

    /** @test */
    function it_obtains_access_token()
    {
        FakeClient::when('POST', 'https://apps.fortnox.se/oauth-v1/token', [
            'access_token' => 'secret_token',
            'refresh_token' => 'secret_refresh_token',
            'scope' => 'testscope',
            'expires_in' => 3600,
            'token_type' => 'Bearer'
        ]);

        $response = Fortnox::verifyAuthCode('test_code');

        $this->assertEquals('secret_token', $response['access_token']);
        $this->assertEquals('secret_refresh_token', $response['refresh_token']);
        $this->assertEquals('testscope', $response['scope']);
        $this->assertEquals(3600, $response['expires_in']);
        $this->assertEquals('Bearer', $response['token_type']);
    }

    /** @test */
    function it_refreshes_token()
    {
        $authenticatable = new AuthenticatableFake();

        FakeClient::when('POST', 'https://apps.fortnox.se/oauth-v1/token', [
            'waevva' => 'sure'
        ]);

        Fortnox::authenticateAs($authenticatable);
        Fortnox::refreshToken();

        $this->assertTrue($authenticatable->refreshTokenCalled);
    }
}
