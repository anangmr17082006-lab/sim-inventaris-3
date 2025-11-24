<?php

namespace App\Enums;

enum AssetCondition: string
{
    case BAIK = 'baik';
    case RUSAK_RINGAN = 'rusak_ringan';
    case RUSAK_BERAT = 'rusak_berat';
}
