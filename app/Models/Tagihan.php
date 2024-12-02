<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    /** @use HasFactory<\Database\Factories\TagihanFactory> */
    use HasFactory;
    protected $fillable = [
        'total',
        'status',
        'deskripsi',
        'reservasi_id',
        'created_by',
        'updated_by',
    ];
}
