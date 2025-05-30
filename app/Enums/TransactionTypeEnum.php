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
            self::Rent => __('enums.transaction_type.rent'),
            self::Purchase => __('enums.transaction_type.purchase'),
            self::Extend => __('enums.transaction_type.extend'),
            self::Fill => __('enums.transaction_type.fill'),
        };
    }
}
