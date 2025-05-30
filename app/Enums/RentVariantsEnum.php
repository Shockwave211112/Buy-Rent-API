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
            self::h4 => __('enums.rent_variant.h4'),
            self::h8 => __('enums.rent_variant.h8'),
            self::h12 => __('enums.rent_variant.h12'),
            self::h24 => __('enums.rent_variant.h24'),
        };
    }
}
