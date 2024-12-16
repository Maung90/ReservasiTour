<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    /** @use HasFactory<\Database\Factories\ReservasiFactory> */
    use HasFactory;
    protected $fillable = [
        'tour_code',
        'tour_date',
        'dob',
        'pax',
        'guest_name',
        'contact',
        'hotel',
        'pickup',
        'remarks',
        'program_id',
        'guide_id',
        'transport_id',
        'sopir_id',
        'bahasa_id',
        'created_by',
        'updated_by',
    ];
      public static function generateTourCode()
    {
        $lastRecord = self::orderBy('id', 'desc')->first();
        $lastId = $lastRecord ? $lastRecord->id : 0;
        return 'TC-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    }

    public function activities()
    {
        return $this->hasMany(ReservasiActivities::class);
    }

    public function flightCode()
    {
        return $this->hasMany(Flight::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }
    public function bahasa()
    {
        return $this->belongsTo(Bahasa::class, 'bahasa_id');
    }
    public function transport()
    {
        return $this->belongsTo(Kendaraan::class, 'transport_id');
    }
    public function sopir()
    {
        return $this->belongsTo(Sopir::class, 'sopir_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
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
