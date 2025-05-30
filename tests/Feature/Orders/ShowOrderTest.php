<?php

namespace Feature\Orders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowOrderTest extends TestCase
{
    protected $method = Request::METHOD_GET;
    protected string $uri = '/api/orders/';

    public function testShouldResponseWithHttpOk()
    {
        $user = User::factory()->create();

        $order = Order::factory()
            ->withUser($user)
            ->create();

        $response = $this->defaultTest(
            $this->method,
            $this->uri . $order->id,
            user: $user,
        )->assertJsonStructure(['data']);

        $this->assertNotEmpty(data_get($response->json(), 'data.code'));
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
