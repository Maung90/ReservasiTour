<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahasa extends Model
{
    /** @use HasFactory<\Database\Factories\BahasaFactory> */
    use HasFactory;

        protected $fillable = [
        'nama_bahasa',
        'harga_bahasa',
    ];
}
