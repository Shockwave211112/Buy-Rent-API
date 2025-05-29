<?php

namespace App\Enums;

enum OrderTypeEnum: string
{
    case Rent = 'rent';
    case Purchase = 'purchase';

    public function label(): string {
        return match ($this) {
            self::Rent => 'Аренда',
            self::Purchase => 'Покупка',
        };
    }
}
