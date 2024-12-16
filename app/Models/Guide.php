<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    /** @use HasFactory<\Database\Factories\GuideFactory> */
    use HasFactory;
    protected $fillable = [
        'nama_guide',
        'no_telp',
        'status',
    ];
    public function bahasa()
    {
        return $this->hasMany(GuideHasBahasa::class, 'guide_id', 'id');
    }
}
