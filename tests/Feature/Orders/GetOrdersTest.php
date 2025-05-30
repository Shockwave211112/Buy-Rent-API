<?php

namespace Tests\Feature\Orders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetOrdersTest extends TestCase
{
    protected $method = Request::METHOD_GET;
    protected string $uri = '/api/orders';

    public function testShouldResponseWithHttpOk()
    {
        $user = User::factory()->create();

        Order::factory()
            ->withUser($user)
            ->count(5)
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri,
            user: $user
        )->assertJsonStructure(['data'])
        ->assertJsonCount(5, 'data');
    }

    public function testShouldResponseWithHttpUnauthIfNotAuth()
    {
        $this->defaultTest(
            $this->method,
            $this->uri,
            Response::HTTP_UNAUTHORIZED,
            needAuth: false
        );
    }
}
