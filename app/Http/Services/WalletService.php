<?php

namespace App\Http\Services;

use App\Exceptions\AuthException;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class WalletService
{
    public function fill(array $data): JsonResponse
    {
        auth()->user()->wallet->increment('balance', $data['amount']);

        return new JsonResponse([
            'message' => 'Кошелёк успешно пополнен.',
        ]);
    }
}
