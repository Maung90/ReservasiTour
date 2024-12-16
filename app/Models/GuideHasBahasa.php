<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideHasBahasa extends Model
{
    /** @use HasFactory<\Database\Factories\GuideHasBahasaFactory> */
    use HasFactory;
    protected $fillable = [
        'guide_id',
        'bahasa_id',
    ];

    // Relasi balik ke Guide
    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id', 'id');
    }

    // Relasi ke Bahasa 
    public function bahasa()
    {
        return $this->belongsTo(Bahasa::class, 'bahasa_id', 'id');
    }
}
