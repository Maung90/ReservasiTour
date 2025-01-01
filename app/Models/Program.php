<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TracksUser;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */

    use TracksUser, HasFactory;
    
    protected $fillable = [
        'nama_program',
        'deskripsi',
        'durasi',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
