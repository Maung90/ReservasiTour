<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    /** @use HasFactory<\Database\Factories\KendaraanFactory> */
    use HasFactory;
    protected $fillable = [
        'nomor_kendaraan',
        'jenis_kendaraan',
        'kapasitas',
        'status',
    ];
}
