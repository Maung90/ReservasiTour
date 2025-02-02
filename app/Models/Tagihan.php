<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\TracksUser;

class Tagihan extends Model
{
    /** @use HasFactory<\Database\Factories\TagihanFactory> */
    use HasFactory,HasUuids,TracksUser;
    // use HasFactory,HasUuids;
    protected $keyType = 'string'; // UUID adalah string
    public $incrementing = false; // Non-incremental ID
    
    protected $fillable = [
        'total',
        'status',
        'reservasi_id',
        // 'created_by',
        // 'updated_by',
    ];
    public function scopeForRoleReservasi($query, $userId, $role)
    {
        return $query->when($role == 5, function ($q) use ($userId) {
            $q->where('reservasis.created_by', $userId);
        });
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id');
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
