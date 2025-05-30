<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    protected $method = Request::METHOD_POST;
    protected string $uri = '/api/auth/login';

    public function testShouldResponseWithHttpOk()
    {
        User::factory()
            ->withEmail('admin@admin.ru')
            ->withPassword('11111111')
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri,
            data: [
                'email' => 'admin@admin.ru',
                'password' => '11111111'
            ],
            needAuth: false,
        )->assertJsonStructure(['token']);
    }

    public function testShouldResponseWithHttpUnprocessableIfNoParams()
    {
        $this->defaultTest(
            $this->method,
            $this->uri,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            needAuth: false,
        );
    }

    public function testShouldResponseWithHttpUnprocessableIfInvalidParams()
    {
        $this->defaultTest(
            $this->method,
            $this->uri,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            data: [
                'email' => 'fsafas.com',
                'password' => '222',
            ],
            needAuth: false,
        );
    }

    public function testShouldResponseWithHttpForbiddenIfWrongPassword()
    {
        User::factory()
            ->withEmail('admin@admin.ru')
            ->withPassword('11111111')
            ->create();

        $this->defaultTest(
            $this->method,
            $this->uri,
            Response::HTTP_FORBIDDEN,
            data: [
                'email' => 'admin@admin.ru',
                'password' => '22222222',
            ],
            needAuth: false,
        );
    }
}
