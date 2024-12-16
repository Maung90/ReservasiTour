<?php

namespace App\Services;

use App\Models\Bahasa;

class BahasaService
{
    public function getBahasa()
    {
        return Bahasa::all();
    }
}
