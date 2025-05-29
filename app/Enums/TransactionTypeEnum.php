<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    case Rent = 'rent';
    case Purchase = 'purchase';
    case Extend = 'extend';

    public function label(): string {
        return match ($this) {
            self::Rent => 'Аренда',
            self::Purchase => 'Покупка',
            self::Extend => 'Продление аренды',
        };
    }
}
