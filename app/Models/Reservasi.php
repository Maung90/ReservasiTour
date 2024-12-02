<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    /** @use HasFactory<\Database\Factories\ReservasiFactory> */
    use HasFactory;
    protected $fillable = [
        'tour_code',
        'tour_date',
        'dob',
        'guest_name',
        'contact',
        'pickup',
        'remarks',
        'program_id',
        'guide_id',
        'transport_id',
        'sopir_id',
        'bahasa_id',
        'created_by',
        'updated_by',
    ];
}
