<?php

namespace App\Services;

use App\Models\Sopir;

class SopirService
{
    public function getSopir()
    {
        return Sopir::all()->where('status', 'available');
    }
}
