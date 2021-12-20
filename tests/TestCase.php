<?php

namespace Iamfredric\Fortnox\Tests;

use Iamfredric\Fortnox\Contracts\Request\ClientInterface;
use Iamfredric\Fortnox\Fortnox;
use Iamfredric\Fortnox\Tests\Fakes\FakeClient;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected ?ClientInterface $client = null;

    protected function setUp(): void
    {
        Fortnox::setClientCredentials(
            clientId: 'test_client',
            clientSecret: 'test_secret',
            redirectUrl: 'https://example.com/callback',
            scope: 'test'
        );

        Fortnox::setHttpClient(
            $this->client = new FakeClient()
        );

        parent::setUp();
    }
}