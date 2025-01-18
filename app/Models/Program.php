<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TracksUser;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */

    use TracksUser, HasFactory;
    // use HasFactory;
    protected $fillable = [
        'nama_program',
        'deskripsi',
        'durasi',
        // 'created_by',
        // 'updated_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function products()
    {
        return $this->belongsToMany(Produk::class, 'detail_programs', 'program_id', 'produk_id');
    }
}
