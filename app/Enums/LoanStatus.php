<?php

namespace App\Enums;

enum LoanStatus: string
{
    case DIPINJAM = 'dipinjam';
    case TELAT = 'telat';
    case KEMBALI = 'kembali';
}
