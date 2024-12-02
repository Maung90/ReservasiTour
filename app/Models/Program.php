<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use HasFactory;
    protected $fillable = [
        'nama_program',
        'deskripsi',
        'durasi',
        'created_by',
        'updated_by',
    ];
}
