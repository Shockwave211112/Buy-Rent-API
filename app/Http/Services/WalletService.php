<?php

namespace App\Http\Services;

use App\Enums\TransactionTypeEnum;
use App\Exceptions\DatabaseException;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function fill(array $data): JsonResponse
    {
        $user = auth()->user();
        $money = $data['amount'];
        try {
            DB::transaction(function () use ($money, $user) {
                $user->wallet->increment('balance', $money);

                Transaction::create([
                    'user_id' => $user->id,
                    'type' => TransactionTypeEnum::Fill,
                    'money' => $money,
                ]);
            });
        } catch (\Throwable $th) {
            throw new DatabaseException('Во время пополнения баланса произошла ошибка.', 500);
        }

        return new JsonResponse([
            'message' => 'Кошелёк успешно пополнен.',
        ]);
    }
}
