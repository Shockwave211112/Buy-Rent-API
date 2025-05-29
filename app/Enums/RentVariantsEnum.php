<?php

namespace App\Enums;

enum RentVariantsEnum: string
{
    case h4 = '4';
    case h8 = '8';
    case h12 = '12';
    case h24 = '24';

    public function label(): string {
        return match ($this) {
            self::h4 => '4 часа',
            self::h8 => '8 часов',
            self::h12 => '12 часов',
            self::h24 => '24 часа',
        };
    }
}
