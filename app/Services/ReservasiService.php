<?php

namespace App\Services;

use App\Models\Reservasi;
use App\Models\ReservasiActivities;
use App\Models\Flight;
use App\Models\Tagihan;
use App\Models\Bahasa;
use App\Models\Guide;
use App\Models\Kendaraan;
use App\Models\Sopir;
use App\Models\DetailProgram;
use Illuminate\Support\Facades\DB;

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
            ]
        );
    }

    public function updateGuideStatusOnReservasi($reservasiId, $newGuideId)
    {
        DB::transaction(function () use ($reservasiId, $newGuideId) {
            $reservasi = Reservasi::find($reservasiId);

            if (!$reservasi) {
                throw new \Exception("Reservasi dengan ID $reservasiId tidak ditemukan.");
            }

            // Ambil guide_id lama dari reservasi
            $oldGuideId = $reservasi->guide_id;

            // Jika ada guide_id lama dan berbeda dengan guide_id baru
            if ($oldGuideId && $oldGuideId != $newGuideId) {
                Guide::where('id', $oldGuideId)->update(['status' => 'available']);
            }

            // Ubah status guide baru menjadi 'unavailable'
            if ($newGuideId) {
                Guide::where('id', $newGuideId)->update(['status' => 'unavailable']);
            }

            $reservasi->update(['guide_id' => $newGuideId]);
        });
    }

    public function updateSopirStatusOnReservasi($reservasiId, $newSopirId)
    {
        DB::transaction(function () use ($reservasiId, $newSopirId) {
            $reservasi = Reservasi::find($reservasiId);

            if (!$reservasi) {
                throw new \Exception("Reservasi dengan ID $reservasiId tidak ditemukan.");
            }

            // Ambil sopir_id lama dari reservasi
            $oldSopirId = $reservasi->sopir_id;

            // Jika ada sopir_id lama dan berbeda dengan sopir_id baru
            if ($oldSopirId && $oldSopirId != $newSopirId) {
                Sopir::where('id', $oldSopirId)->update(['status' => 'available']);
            }

            // Ubah status Sopir baru menjadi 'unavailable'
            if ($newSopirId) {
                Sopir::where('id', $newSopirId)->update(['status' => 'unavailable']);
            }

            $reservasi->update(['sopir_id' => $newSopirId]);
        });
    }

    public function updateKendaraanStatusOnReservasi($reservasiId, $newKendaraanId)
    {
        DB::transaction(function () use ($reservasiId, $newKendaraanId) {
            $reservasi = Reservasi::find($reservasiId);

            if (!$reservasi) {
                throw new \Exception("Reservasi dengan ID $reservasiId tidak ditemukan.");
            }

            // Ambil transport_id lama dari reservasi
            $oldKendaraanId = $reservasi->transport_id;

            // Jika ada transport_id lama dan berbeda dengan transport_id baru
            if ($oldKendaraanId && $oldKendaraanId != $newKendaraanId) {
                Kendaraan::where('id', $oldKendaraanId)->update(['status' => 'available']);
            }

            // Ubah status Kendaraan baru menjadi 'unavailable'
            if ($newKendaraanId) {
                Kendaraan::where('id', $newKendaraanId)->update(['status' => 'unavailable']);
            }

            $reservasi->update(['transport_id' => $newKendaraanId]);
        });
    }


}
