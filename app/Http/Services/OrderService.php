<?php

namespace App\Http\Services;

use App\Enums\OrderTypeEnum;
use App\Enums\TransactionTypeEnum;
use App\Exceptions\DatabaseException;
use App\Exceptions\OrderException;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrderService
{
    public function index($query): JsonResource
    {
        $page = $query->get('page', 1);

        $sortDir = $query->get('dir', 'desc');
        $sortDir = in_array($sortDir, ['asc', 'desc']) ? $sortDir : 'desc';

        $user = auth()->user();

        $orders = Cache::tags(["User_{$user->id}_Orders"])
            ->remember(
                "user_{$user->id}_orders_{$page}_{$sortDir}",
                60,
                fn () => $user->orders()
                    ->orderBy('created_at', $sortDir)
                    ->paginate(15)
            );

        return OrderResource::collection($orders);
    }

    /**
     * @param array $data
     * @return JsonResponse
     * @throws OrderException
     */
    public function create(array $data): JsonResponse
    {
        $product = Product::find($data['product_id']);
        if (!$product) {
            throw new OrderException(__('errors.product.not_found'), 404);
        }

        $user = auth()->user();
        $start_at = now();
        $type = $data['type'];

        switch ($type) {
            case OrderTypeEnum::Purchase->value:
                $requiredPrice = $product->price;
                $end_at = null;
                $details = null;
                break;
            case OrderTypeEnum::Rent->value:
                $hours = $data['time'];
                $requiredPrice = $product->{'rent_price_' . $hours . 'h'};
                $end_at = $start_at->copy()->addHours($hours);
                $details = __('messages.transactions.rent', ['hours' => $hours]);
                break;
            default:
                throw new OrderException(__('errors.order.create'), 500);
        }

        try {
            DB::transaction(function () use ($user, $requiredPrice, $product, $start_at, $end_at, $type, $details) {
                if ($user->wallet->balance < $requiredPrice) {
                    throw new OrderException(__('errors.wallet.not_enough'), 422);
                }
                if ($product->count < 1) {
                    throw new OrderException(__('errors.product.out_of_stock'), 422);
                }

                $user->wallet->decrement('balance', $requiredPrice);
                $product->decrement('count', 1);

                $order = Order::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'type' => $type,
                    'is_active' => true,
                    'start_at' => $start_at,
                    'end_at' => $end_at,
                ]);

                Transaction::create([
                    'user_id' => $user->id,
                    'type' => $type,
                    'order_id' => $order->id,
                    'details' => $details ?? null,
                    'money' => $requiredPrice,
                ]);
            });
        } catch (\Throwable $th) {
            throw new DatabaseException($th->getMessage() ?: __('errors.order.create'), $th->status ?: 500);
        }

        return new JsonResponse([
            'message' => __('messages.order.success'),
        ]);
    }

    /**
     * @param int $id
     * @param array $data
     * @return JsonResponse
     * @throws OrderException
     */
    public function extend(int $id, array $data): JsonResponse
    {
        $user = auth()->user();
        $hours = $data['time'];

        $order = Order::find($id);
        if (!$order) {
            throw new OrderException(__('errors.order.not_found'), 404);
        }

        Gate::authorize('extend', $order);

        if ($order->product->deleted_at) {
            throw new OrderException(__('errors.product.deleted'), 422);
        }

        if ($order->isExpired() || $order->type == OrderTypeEnum::Purchase) {
            throw new OrderException(__('errors.order.expired'), 422);
        }

        $newEndDate = Carbon::parse($order->end_at)->addHours($hours);
        if ($newEndDate->diffInHours($order->start_at) > 24) {
            throw new OrderException(__('errors.order.more_than_24'), 422);
        }

        $requiredPrice = $order->product->{'rent_price_' . $hours . 'h'};

        try {
            DB::transaction(function () use ($user, $order, $newEndDate, $requiredPrice, $hours) {
                if ($user->wallet->balance < $requiredPrice) {
                    throw new OrderException(__('errors.wallet.not_enough'), 422);
                }

                $user->wallet->decrement('balance', $requiredPrice);

                $order->update([
                    'end_at' => $newEndDate,
                ]);

                Transaction::create([
                    'user_id' => $user->id,
                    'type' => TransactionTypeEnum::Extend,
                    'order_id' => $order->id,
                    'details' => __('messages.transactions.extend', ['hours' => $hours]),
                    'money' => $requiredPrice,
                ]);
            });
        } catch (\Throwable $th) {
            throw new DatabaseException($th->getMessage() ?: __('errors.order.extend'), $th->status ?: 500);
        }

        return new JsonResponse([
            'message' => __('messages.order.extend'),
        ]);
    }

    /**
     * @param int $id
     * @return JsonResource
     * @throws OrderException
     */
    public function show(int $id): JsonResource
    {
        $order = Order::find($id);
        if (!$order) {
            throw new OrderException(__('errors.order.not_found'), 404);
        }

        Gate::authorize('view', $order);

        $this->generateCode($order);

        return new OrderResource($order);
    }

    /**
     * Функция для генерации уникального кода заказа при проверке его статуса (открытии).
     *
     * @param Order $order
     * @return bool
     */
    public function generateCode(Order $order)
    {
        if (!$order->code) {
            do {
                $code = substr(md5(mt_rand()), 0, 12);
            } while (Order::where('code', $code)->exists());

            $order->update([
                'code' => $code,
                'code_generated_at' => now(),
            ]);

            return true;
        }

        return false;
    }
}
