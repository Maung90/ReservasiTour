<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;
    protected $fillable = [
        'nama_produk',
        'harga',
        'area',
        'deskripsi',
        'tipe_produk',
        'vendor_id',
        'created_by',
        'updated_by',
    ];
}
