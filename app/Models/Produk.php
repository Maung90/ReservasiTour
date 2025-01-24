<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TracksUser;

class Produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    // use HasFactory, TracksUser;
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
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
