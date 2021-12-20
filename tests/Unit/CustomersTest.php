<?php

namespace Iamfredric\Fortnox\Tests\Unit;

use Iamfredric\Fortnox\Fortnox;
use Iamfredric\Fortnox\Resources\Customer;
use Iamfredric\Fortnox\Tests\Fakes\AuthenticatableFake;
use Iamfredric\Fortnox\Tests\Fakes\FakeClient;
use Iamfredric\Fortnox\Tests\TestCase;

class CustomersTest extends TestCase
{
    protected function setUp(): void
    {
        $this->setHttpClientResponses()
            ->asAuthenticated();

        parent::setUp();
    }

    /** @test */
    function all_customers_can_be_fetched()
    {
        $customers = Customer::all();

        $this->assertCount(2, $customers);

        $customers = $customers->toArray();

        $this->assertEquals('1', $customers[0]['CustomerNumber']);
        $this->assertEquals('2', $customers[1]['CustomerNumber']);
    }

    /** @test */
    function a_single_customer_can_be_fetched()
    {
        $customer = Customer::find(1);

        $this->assertEquals('Test Customer', $customer->Name);
    }

    /** @test */
    function a_customer_can_be_created()
    {
        $customer = Customer::create([
            "Name" => "Acme INC"
        ]);

        $this->assertEquals('Acme INC', $customer->Name);
    }

    /** @test */
    function a_customer_can_be_updated()
    {
        $customer = new Customer([
            'CustomerNumber' => '1'
        ]);

        $customer->update([
            'Name' => 'Test Customer'
        ]);

        $this->assertEquals('Test Customer', $customer->Name);
    }

    /** @test */
    function a_customer_can_be_deleted()
    {
        $customer = new Customer([
            'CustomerNumber' => '1001'
        ]);

        $response = $customer->delete();

        $this->assertTrue($response['deleted']);
    }

    protected function setHttpClientResponses(): static
    {
        foreach ([
            'GET' => [
                'https://api.fortnox.se/3/customers' => [
                    'Customers' => [[
                        'CustomerNumber' => '1',
                        'Name' => 'Test Customer',
                        'Email' => ''
                    ], [
                        'CustomerNumber' => '2',
                        'Name' => 'Test Customer 2',
                        'Email' => ''
                    ]]
                ],
                'https://api.fortnox.se/3/customers/1' => [
                    'Customer' => [
                        'CustomerNumber' => '1',
                        'Name' => 'Test Customer',
                        'Email' => ''
                    ]
                ]
            ],
            'POST' => [
                'https://api.fortnox.se/3/customers' => [
                    'Customer' => [
                        'CustomerNumber' => '1',
                        'Name' => 'Acme INC',
                        'Email' => ''
                    ]
                ]
            ],
            'PUT' => [
                'https://api.fortnox.se/3/customers/1' => [
                    'Customer' => [
                        'CustomerNumber' => '1',
                        'Name' => 'Test Customer',
                        'Email' => ''
                    ]
                ]
            ],
            'DELETE' => [
                'https://api.fortnox.se/3/customers/1001' => [
                    'deleted' => true
                ]
            ]
        ] as $method => $endpoints) {
            foreach ($endpoints as $endpoint => $response) {
                FakeClient::when($method, $endpoint, $response);

            }
        }

        return $this;
    }

    protected function asAuthenticated(): static
    {
        Fortnox::authenticateAs(new AuthenticatableFake());

        return $this;
    }
}