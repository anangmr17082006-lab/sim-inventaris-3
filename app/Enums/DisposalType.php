<?php

namespace App\Enums;

enum DisposalType: string
{
    case RUSAK_TOTAL = 'rusak_total';
    case HILANG = 'hilang';
    case KADALUARSA = 'kadaluarsa';
    case DIJUAL = 'dijual';
    case DIHIBAHKAN = 'dihibahkan';
    case AUS_USANG = 'aus_usang';

    public function label(): string
    {
        return match ($this) {
            self::RUSAK_TOTAL => 'Rusak Total',
            self::HILANG => 'Hilang/Dicuri',
            self::KADALUARSA => 'Kadaluarsa',
            self::DIJUAL => 'Dijual',
            self::DIHIBAHKAN => 'Dihibahkan',
            self::AUS_USANG => 'Aus/Usang',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::RUSAK_TOTAL => 'red',
            self::HILANG => 'orange',
            self::KADALUARSA => 'yellow',
            self::DIJUAL => 'green',
            self::DIHIBAHKAN => 'blue',
            self::AUS_USANG => 'gray',
        };
    }
}
