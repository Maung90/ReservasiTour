<?php

namespace App\Services;

use App\Models\Program;

class ProgramService
{
    public function getProgram()
    {
        return Program::with('products')->get();
    }
}
