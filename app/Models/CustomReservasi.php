<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomReservasi extends Model
{
    /** @use HasFactory<\Database\Factories\CustomReservasiFactory> */
    use HasFactory;
    protected $fillable = [
        'reservasi_id',
        'produk_id',
    ];
}
