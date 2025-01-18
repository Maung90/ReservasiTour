<?php

namespace App\Services;

use App\Models\Produk;

class ProdukService
{
    public function getProduk()
    {
        return Produk::all();
    }
}
