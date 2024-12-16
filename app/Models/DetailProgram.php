<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProgram extends Model
{
    /** @use HasFactory<\Database\Factories\DetailProgramFactory> */
    use HasFactory;
    protected $fillable = [
        'program_id',
        'produk_id',
    ];
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

}
