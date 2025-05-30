<?php

namespace Tests\Feature\Orders;

use App\Enums\OrderTypeEnum;
use App\Enums\RentVariantsEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class ExtendOrderTest extends TestCase
{
    protected $method = Request::METHOD_POST;
    protected string $uri = '/api/orders/';

    public function testShouldResponseWithHttpOkOnExtend()
    {
        $wallet = 1000;
        $price = 100;

        $user = User::factory()
            ->withBalance($wallet)
            ->create();

        $product = Product::factory()
            ->withRent($price)
            ->create();

        $order = Order::factory()
            ->withProduct($product)
            ->withType(OrderTypeEnum::Rent)
            ->withStart(now())
            ->withEnd(now()->addHours(1))
            ->withUser($user)
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri . $order->id . '/extend',
            data: [
                'time' => RentVariantsEnum::h4,
            ],
            user: $user,
        );

        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'balance' => $wallet - $price,
        ]);
    }

    public function testShouldResponseWithHttpUnprocessableIfExpired()
    {
        $wallet = 1000;
        $price = 100;

        $user = User::factory()
            ->withBalance($wallet)
            ->create();

        $product = Product::factory()
            ->withRent($price)
            ->create();

        $order = Order::factory()
            ->withProduct($product)
            ->withType(OrderTypeEnum::Rent)
            ->withStatus(false)
            ->withUser($user)
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri . $order->id . '/extend',
            Response::HTTP_UNPROCESSABLE_ENTITY,
            data: [
                'time' => RentVariantsEnum::h4,
            ],
            user: $user,
        );
    }

    public function testShouldResponseWithHttpUnprocessableIfNotRent()
    {
        $wallet = 1000;
        $price = 100;

        $user = User::factory()
            ->withBalance($wallet)
            ->create();

        $product = Product::factory()
            ->withRent($price)
            ->create();

        $order = Order::factory()
            ->withProduct($product)
            ->withType(OrderTypeEnum::Purchase)
            ->withUser($user)
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri . $order->id . '/extend',
            Response::HTTP_UNPROCESSABLE_ENTITY,
            data: [
                'time' => RentVariantsEnum::h4,
            ],
            user: $user,
        );
    }

    public function testShouldResponseWithHttpUnprocessableIfWrongTime()
    {
        $wallet = 1000;
        $price = 100;

        $user = User::factory()
            ->withBalance($wallet)
            ->create();

        $product = Product::factory()
            ->withRent($price)
            ->create();

        $order = Order::factory()
            ->withProduct($product)
            ->withType(OrderTypeEnum::Rent)
            ->withUser($user)
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri . $order->id . '/extend',
            Response::HTTP_UNPROCESSABLE_ENTITY,
            data: [
                'time' => 11,
            ],
            user: $user,
        );
    }

    public function testShouldResponseWithHttpUnprocessableIfMoreThan24Hours()
    {
        $wallet = 1000;
        $price = 100;

        $user = User::factory()
            ->withBalance($wallet)
            ->create();

        $product = Product::factory()
            ->withRent($price)
            ->create();

        $order = Order::factory()
            ->withProduct($product)
            ->withStart(now())
            ->withEnd(now()->addHours(12))
            ->withType(OrderTypeEnum::Rent)
            ->withUser($user)
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri . $order->id . '/extend',
            Response::HTTP_UNPROCESSABLE_ENTITY,
            data: [
                'time' => RentVariantsEnum::h24,
            ],
            user: $user,
        );
    }

    public function testShouldResponseWithHttpUnauthIfNotAuth()
    {
        $order = Order::factory()
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri . $order->id . '/extend',
            Response::HTTP_UNAUTHORIZED,
            needAuth: false
        );
    }
}
