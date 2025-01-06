<?php

namespace App\Http\Controllers;
use App\Models\Reservasi;
use App\Models\ReservasiActivities;
use App\Models\Flight;
use App\Models\Bahasa;
use App\Models\Tagihan;
use App\Models\DetailProgram;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

use App\Services\BahasaService;
use App\Services\SopirService;
use App\Services\GuideService;
use App\Services\ProgramService;
use App\Services\KendaraanService;
use App\Services\ReservasiService;

class ReservasiController extends Controller
{
    protected $bahasaService, $guideService, $kendaraanService, $sopirService, $programService, $reservasiService;

    public function __construct(BahasaService $bahasaService, SopirService $sopirService, GuideService $guideService, ProgramService $programService, KendaraanService $kendaraanService, ReservasiService $reservasiService)
    {
        $this->bahasaService = $bahasaService;
        $this->sopirService = $sopirService;
        $this->guideService = $guideService;
        $this->programService = $programService;
        $this->kendaraanService = $kendaraanService;
        $this->reservasiService = $reservasiService;
    }
    public function reservasi()
    {
        $bahasas = $this->bahasaService->getBahasa();
        $guides = $this->guideService->getGuide();
        $sopirs = $this->sopirService->getSopir();
        $programs = $this->programService->getProgram();
        $kendaraans = $this->kendaraanService->getKendaraan();

        return view('reservasi.reservasi',compact('bahasas','guides', 'sopirs', 'programs', 'kendaraans'));
    }
    public function tablereservasi() 
    {
        $reservasis = Reservasi::orderBy('tour_code', 'desc')->get();

        $data = DataTables::of($reservasis)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('dob', function ($row) {
            return Carbon::parse($row->dob)->format('d F Y');
        })
        ->addColumn('tour_date', function ($row) {
            return Carbon::parse($row->tour_date)->format('d F Y');
        })
        ->addColumn('guest_name', function ($row) {
            return $row->guest_name;
        })
        ->addColumn('tour_code', function ($row) {
            return $row->tour_code;
        })
        ->addColumn('contact', function ($row) {
            return $row->contact;
        })
        ->addColumn('action', function ($row) {
            $user = auth()->user();
            $buttons = '
            <button type="button" class="capitalize btn btn-sm waves-effect waves-light btn-success info-btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#info-modal">
            <i class="ti ti-info-circle"></i>
            </button>';
            if ($user->role_id == 3 || $user->role_id == 1) {
                $buttons .= '
                <button type="button" class="capitalize btn btn-sm waves-effect waves-light btn-warning edit-btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-modal">
                <i class="ti ti-pencil"></i>
                </button>';
            }
            if ($user->role_id == 1) {
                $buttons .= '
                <button type="button" class="btn btn-sm waves-effect waves-light btn-danger delete-btn" id="sa-confirm" data-id="'.$row->id.'">
                <i class="ti ti-trash"></i>
                </button>';
            }
            return $buttons;

        })
        ->rawColumns(['action'])
        ->make(true);

        return $data;
    }

    public function get($id)
    {
        $reservasi = Reservasi::with(['guide','sopir','transport','bahasa','program','creator','updator','flightCode','activities'])->find($id);
        $arr = [
            'tour_code' => $reservasi->tour_code,
            'contact' => $reservasi->contact,
            'dob' => Carbon::parse($reservasi->dob)->format('d F Y'),
            'guest_name' => $reservasi->guest_name,
            'hotel' => $reservasi->hotel,
            'pax' => $reservasi->pax,
            'pickup' => Carbon::parse($reservasi->pickup)->format('d F Y, H:m'),
            'remarks' => $reservasi->remarks,
            'tour_date' => Carbon::parse($reservasi->tour_date)->format('d F Y'),
            'updated_at' => $reservasi->updated_at,

            'flight_code_depacture' => count($reservasi->flightCode) != 0 ? $reservasi->flightCode[0]->flight_code : '-',
            'flight_code_arrival' => count($reservasi->flightCode)  != 0 ? $reservasi->flightCode[1]->flight_code : '-',
            'eta' => count($reservasi->flightCode) != 0 ? $reservasi->flightCode[0]->time : '-',
            'etd' => count($reservasi->flightCode)  != 0 ? $reservasi->flightCode[1]->time : '-',
            'activities' => count($reservasi->activities) != 0 ? $reservasi->activities[0]->aktivitas : '-',

            'guide' => $reservasi->guide->nama_guide,
            'bahasa' => $reservasi->bahasa->nama_bahasa,
            'program' => $reservasi->program->nama_program,
            'sopir' => $reservasi->sopir->nama_sopir,
            'transport' => $reservasi->transport->jenis_kendaraan,
            'creator' => $reservasi->creator->nama,
            'updator' => $reservasi->updator->nama,


            'dob_edit' => $reservasi->dob,
            'pickup_edit' => $reservasi->pickup,
            'tour_date_edit' => $reservasi->tour_date,
            'guide_id' => $reservasi->guide_id,
            'bahasa_id' => $reservasi->bahasa_id,
            'program_id' => $reservasi->program_id,
            'sopir_id' => $reservasi->sopir_id,
            'transport_id' => $reservasi->transport_id,
        ];
        return response()->json($arr);
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::find($id);

        if ($reservasi) {
            $reservasi->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $this->reservasiService->validateInput($request);

        try {
            $reservasi = $this->reservasiService->createReservasi($request);
            $this->reservasiService->handleActivities($request, $reservasi->id);
            $this->reservasiService->handleFlights($request, $reservasi->id);
            $this->reservasiService->updateGuideStatusOnReservasi($reservasi->id, $request->guide_id);
            $this->reservasiService->updateSopirStatusOnReservasi($reservasi->id, $request->sopir_id);
            $this->reservasiService->updateKendaraanStatusOnReservasi($reservasi->id, $request->kendaraan_id);

            $total = $this->reservasiService->calculateTotal($request);
            $this->reservasiService->updateOrCreateTagihan($reservasi->id, $total);

            return response()->json([
                'message' => 'Reservasi berhasil dibuat.',
                'data' => $reservasi
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat reservasi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $this->reservasiService->validateInput($request);

        try {
            $reservasi = Reservasi::findOrFail($id);
            $this->reservasiService->updateReservasi($reservasi, $request);
            $this->reservasiService->updateActivities($reservasi->id, $request);
            $this->reservasiService->updateFlightDetails($reservasi->id, $request);
            $this->reservasiService->updateGuideStatusOnReservasi($reservasi->id, $request->guide_id);
            $this->reservasiService->updateSopirStatusOnReservasi($reservasi->id, $request->sopir_id);
            $this->reservasiService->updateKendaraanStatusOnReservasi($reservasi->id, $request->transport_id);

            $total = $this->reservasiService->calculateTotal($request);
            $this->reservasiService->updateOrCreateTagihan($reservasi->id, $total);

            return response()->json([
                'message' => 'Reservasi berhasil diperbarui.',
                'data' => $reservasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui reservasi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
