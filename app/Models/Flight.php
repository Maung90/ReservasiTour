<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /** @use HasFactory<\Database\Factories\FlightFactory> */
    use HasFactory;
    protected $fillable = [
        'flight_code',
        'type',
        'time',
        'reservasi_id',
    ];
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }
}
