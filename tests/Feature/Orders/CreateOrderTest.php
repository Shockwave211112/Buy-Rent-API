<?php

namespace Tests\Feature\Orders;

use App\Enums\OrderTypeEnum;
use App\Enums\RentVariantsEnum;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    protected $method = Request::METHOD_POST;
    protected string $uri = '/api/orders';

    public function testShouldResponseWithHttpOkOnRent()
    {
        $wallet = 10000;
        $price = 1000;

        $user = User::factory()
            ->withBalance($wallet)
            ->create();

        $product = Product::factory()
            ->withRent($price)
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri,
            data: [
                'product_id' => $product->id,
                'type' => OrderTypeEnum::Rent,
                'time' => RentVariantsEnum::h4,
            ],
            user: $user,
        );

        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'balance' => $wallet - $price,
        ]);

        $this->assertDatabaseHas('orders', [
            'product_id' => $product->id,
            'type' => OrderTypeEnum::Rent,
            'user_id' => $user->id,
        ]);
    }

    public function testShouldResponseWithHttpOkOnPurchase()
    {
        $wallet = 10000;
        $price = 1000;

        $user = User::factory()
            ->withBalance($wallet)
            ->create();

        $product = Product::factory()
            ->withPrice($price)
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri,
            data: [
                'product_id' => $product->id,
                'type' => OrderTypeEnum::Purchase,
            ],
            user: $user,
        );

        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'balance' => $wallet - $price,
        ]);

        $this->assertDatabaseHas('orders', [
            'product_id' => $product->id,
            'type' => OrderTypeEnum::Purchase,
            'user_id' => $user->id,
        ]);
    }

    public function testShouldResponseWithHttpUnprocessableIfNotEnoughMoneyForBuy()
    {
        $user = User::factory()
            ->create();

        $product = Product::factory()
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            data: [
                'product_id' => $product->id,
                'type' => OrderTypeEnum::Purchase,
            ],
            user: $user,
        );
    }

    public function testShouldResponseWithHttpUnprocessableIfNotEnoughMoneyForRent()
    {
        $user = User::factory()
            ->create();

        $product = Product::factory()
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            data: [
                'product_id' => $product->id,
                'type' => OrderTypeEnum::Rent,
                'time' => RentVariantsEnum::h4,
            ],
            user: $user,
        );
    }

    public function testShouldResponseWithHttpUnprocessableIfNotSetTimeForRent()
    {
        $user = User::factory()
            ->withBalance(10000)
            ->create();

        $product = Product::factory()
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            data: [
                'product_id' => $product->id,
                'type' => OrderTypeEnum::Rent,
            ],
            user: $user,
        );
    }

    public function testShouldResponseWithHttpUnprocessableIfNotSetType()
    {
        $user = User::factory()
            ->withBalance(10000)
            ->create();

        $product = Product::factory()
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            data: [
                'product_id' => $product->id,
            ],
            user: $user,
        );
    }

    public function testShouldResponseWithHttpNotFoundOnProduct()
    {
        $user = User::factory()
             ->create();

        $this->defaultTest(
            $this->method,
            $this->uri,
            Response::HTTP_NOT_FOUND,
            data: [
                 'product_id' => 9999,
                 'type' => OrderTypeEnum::Purchase,
             ],
            user: $user,
        );
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
