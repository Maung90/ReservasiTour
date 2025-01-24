<?php

namespace App\Services;

use App\Models\Kendaraan;

class KendaraanService
{
    public function getKendaraan()
    {
        return Kendaraan::all()->where('status', 'available');
    }
}
