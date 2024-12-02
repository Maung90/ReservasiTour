<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideHasBahasa extends Model
{
    /** @use HasFactory<\Database\Factories\GuideHasBahasaFactory> */
    use HasFactory;
    protected $fillable = [
        'guide_id',
        'bahasa_id',
    ];
}
