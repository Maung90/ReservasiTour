<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservasiActivities extends Model
{
    /** @use HasFactory<\Database\Factories\ReservasiActivitiesFactory> */
    use HasFactory;
    protected $fillable = [
        'aktivitas',
        'reservasi_id',
    ];
}
