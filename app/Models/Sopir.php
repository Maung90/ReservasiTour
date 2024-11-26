<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sopir extends Model
{
    /** @use HasFactory<\Database\Factories\SopirFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_sopir',
        'no_telp',
        'status',
    ];
}
