<?php

namespace App\Services;

use App\Models\Reservasi;
use App\Models\ReservasiActivities;
use App\Models\Flight;
use App\Models\Tagihan;
use App\Models\Bahasa;
use App\Models\DetailProgram;

class ReservasiService
{

    public function validateInput($request)
    {
        $request->validate([
            'tour_date' => 'nullable|date',
            'program_id' => 'nullable|integer',
            'pax' => 'nullable|integer',
            'agent' => 'nullable|string|max:255',
            'guest_name' => 'required|string|max:100',
            'contact' => 'nullable|string|max:100',
            'hotel' => 'nullable|string|max:100',
            'pickup' => 'nullable|date',
            'guide_id' => 'nullable|integer',
            'transport_id' => 'nullable|integer',
            'sopir_id' => 'nullable|integer',
            'remarks' => 'nullable|string',
            'bahasa_id' => 'nullable|integer',
            'activities' => 'nullable|string|max:255', 
            'flight_code.arrival_code' => 'nullable|string|max:10',
            'flight_code.departure_code' => 'nullable|string|max:10',
            'flight_code.eta' => 'nullable|date',
            'flight_code.etd' => 'nullable|date',
        ]);
    }

    public function createReservasi($request)
    {
        return Reservasi::create([
            'dob' => now(),
            'tour_date' => $request->tour_date,
            'program_id' => $request->program_id,
            'pax' => $request->pax,
            'agent' => $request->agent,
            'guest_name' => $request->guest_name,
            'tour_code' => Reservasi::generateTourCode(),
            'contact' => $request->contact,
            'hotel' => $request->hotel,
            'pickup' => $request->pickup,
            'guide_id' => $request->guide_id,
            'transport_id' => $request->transport_id,
            'sopir_id' => $request->sopir_id,
            'remarks' => $request->remarks,
            'bahasa_id' => $request->bahasa_id ?? '1',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
    }

    public function handleActivities($request, $reservasiId)
    {
        if ($request->has('activities')) {
            ReservasiActivities::create([
                'reservasi_id' => $reservasiId,
                'aktivitas' => $request->activities
            ]);
        }
    }

    public function handleFlights($request, $reservasiId)
    {
        if ($request->has('flight_code')) {
            if (!empty($request->flight_code['arrival_code'])) {
                Flight::create([
                    'reservasi_id' => $reservasiId,
                    'flight_code' => $request->flight_code['arrival_code'],
                    'time' => $request->flight_code['eta'],
                    'type' => 'arrival',
                ]);
            }

            if (!empty($request->flight_code['departure_code'])) {
                Flight::create([
                    'reservasi_id' => $reservasiId,
                    'flight_code' => $request->flight_code['departure_code'],
                    'time' => $request->flight_code['etd'],
                    'type' => 'departure',
                ]);
            }
        }
    }

    public function calculateTotal($request)
    {
        $dataProduk = DetailProgram::with('produk')
        ->where('program_id', $request->program_id)
        ->get();

        $hargaProduk = $dataProduk->sum(function ($detail) {
            return $detail->produk->harga;
        });

        $hargaBahasa = Bahasa::where('id', $request->bahasa_id)->value('harga_bahasa');

        $total = (doubleval($request->pax) * doubleval($hargaProduk)) + doubleval($hargaBahasa);

       return $total;
    }

    public function updateReservasi($reservasi, $request)
    {
        $reservasi->update([
            'tour_date' => $request->tour_date,
            'program_id' => $request->program_id,
            'pax' => $request->pax,
            'agent' => $request->agent,
            'guest_name' => $request->guest_name,
            'contact' => $request->contact,
            'hotel' => $request->hotel,
            'pickup' => $request->pickup,
            'guide_id' => $request->guide_id,
            'transport_id' => $request->transport_id,
            'sopir_id' => $request->sopir_id,
            'remarks' => $request->remarks,
            'bahasa_id' => $request->bahasa_id,
            'updated_by' => '1',
        ]);
    }

    public function updateActivities($reservasiId, $request)
    {
        if ($request->has('activities')) {
            ReservasiActivities::updateOrCreate(
                ['reservasi_id' => $reservasiId],
                ['aktivitas' => $request->activities]
            );
        }
    }

    public function updateFlightDetails($reservasiId, $request)
    {
        if ($request->has('flight_code')) {
            Flight::updateOrCreate(
                ['reservasi_id' => $reservasiId, 'type' => 'arrival'],
                [
                    'flight_code' => $request->flight_code['arrival_code'],
                    'time' => $request->flight_code['eta'],
                ]
            );

            Flight::updateOrCreate(
                ['reservasi_id' => $reservasiId, 'type' => 'departure'],
                [
                    'flight_code' => $request->flight_code['departure_code'],
                    'time' => $request->flight_code['etd'],
                ]
            );
        }
    }

    public function updateOrCreateTagihan($reservasiId, $total)
    {
        Tagihan::updateOrCreate(
            ['reservasi_id' => $reservasiId],
            [
                'total' => $total,
                'status' => 'pending',
                'deskripsi' => '-',
                'created_by' => '1',
                'updated_by' => '1',
            ]
        );
    }


}
