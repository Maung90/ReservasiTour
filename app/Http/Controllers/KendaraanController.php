<?php

namespace App\Http\Controllers;
use App\Models\Kendaraan; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class KendaraanController extends Controller
{
    public function kendaraan()
    {
        return view('kendaraan.kendaraan');
    }
    public function tableKendaraan() 
    {
        $kendaraans = Kendaraan::all();

        $data = DataTables::of($kendaraans)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('jenis_kendaraan', function ($row) {
            return $row->jenis_kendaraan;
        })
        ->addColumn('nomor_kendaraan', function ($row) {
            return $row->nomor_kendaraan;
        })
        ->addColumn('kapasitas', function ($row) {
            return $row->kapasitas;
        })
        ->addColumn('status', function ($row) {
            return $row->status;
        })
        ->addColumn('action', function ($row) {
            return '
            <button type="button" class="capitalize btn btn-sm waves-effect waves-light btn-warning edit-btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-modal">
            <i class="ti ti-pencil"></i>
            </button>
            <button type="button" class="btn btn-sm waves-effect waves-light btn-danger delete-btn" id="sa-confirm" data-id="'.$row->id.'">
            <i class="ti ti-trash"></i>
            </button>
            ';

        })
        ->make(true);

        return $data;
    }

    public function get($id)
    {
        $kendaraan = Kendaraan::find($id);

        return response()->json($kendaraan);
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);
        
        if ($kendaraan) {
            $kendaraan->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_kendaraan' => 'required|string|max:255',
            'nomor_kendaraan' => 'required|string|max:50',
            'kapasitas' => 'required|numeric',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try{  
            $kendaraan = Kendaraan::create([
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'nomor_kendaraan' => $request->nomor_kendaraan,
                'kapasitas' => $request->kapasitas,
                'status' => $request->status,
            ]);

            return response()->json(['message' => 'Kendaraan created successfully!', 'data' => $kendaraan], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Kendaraan created failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_kendaraan' => 'required|string|max:255',
            'nomor_kendaraan' => 'required|string|max:50',
            'kapasitas' => 'required|numeric',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $kendaraan = Kendaraan::findOrFail($id);

            $kendaraan->update([
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'nomor_kendaraan' => $request->nomor_kendaraan,
                'kapasitas' => $request->kapasitas,
                'status' => $request->status,
            ]);

            return response()->json(['message' => 'Kendaraan updated successfully!', 'data' => $kendaraan], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Kendaraan updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

}