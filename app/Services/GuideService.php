<?php

namespace App\Services;

use App\Models\Guide;

class GuideService
{
    public function getGuide()
    {
        return Guide::with('bahasa.bahasa')->where('status','available')->get();
    }
}
