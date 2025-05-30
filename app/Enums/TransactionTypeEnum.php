<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    case Rent = 'rent';
    case Purchase = 'purchase';
    case Extend = 'extend';
    case Fill = 'fill';

    public function label(): string {
        return match ($this) {
            self::Rent => 'Аренда',
            self::Purchase => 'Покупка',
            self::Extend => 'Продление аренды',
            self::Fill => 'Пополнение счёта',
        };
    }
}
