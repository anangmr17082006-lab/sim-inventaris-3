<?php

namespace App\Enums;

enum AssetStatus: string
{
    case TERSEDIA = 'tersedia';
    case DIPINJAM = 'dipinjam';
    case RUSAK = 'rusak';
    case HILANG = 'hilang';
}
