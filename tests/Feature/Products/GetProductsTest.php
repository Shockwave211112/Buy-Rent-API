<?php

namespace Feature\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use Tests\TestCase;

class GetProductsTest extends TestCase
{
    protected $method = Request::METHOD_GET;
    protected string $uri = '/api/products';

    public function testShouldResponseWithHttpOk()
    {
        $this->defaultTest(
            $this->method,
            $this->uri,
            needAuth: false,
        )->assertJsonStructure(['data'])
        ->assertJsonCount(3, 'data');
    }
}
