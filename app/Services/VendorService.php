<?php

namespace App\Services;

use App\Models\Vendor;

class VendorService
{
    public function getVendor()
    {
        return Vendor::all();
    }
}
