<?php

namespace App\Http\Controllers;
use App\Models\Sopir; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class SopirController extends Controller
{
    public function sopir()
    {
        return view('sopir.sopir');
    }
    public function tableSopir() 
    {
        $sopirs = Sopir::all();

        $data = DataTables::of($sopirs)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('nama_sopir', function ($row) {
            return $row->nama_sopir;
        })
        ->addColumn('no_telp', function ($row) {
            return $row->no_telp;
        })
        ->addColumn('status', function ($row) {
            $status = $row->status == "available" ? " bg-success" : "bg-danger";
            return '<span class="badge rounded-pill '.$status.'">'.$row->status.'</span>';
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

        })->rawColumns(['action','status'])
        ->make(true);

        return $data;
    }

    public function get($id)
    {
        $sopir = Sopir::find($id);

        return response()->json($sopir);
    }

    public function destroy($id)
    {
        $sopir = Sopir::find($id);
        
        if ($sopir) {
            $sopir->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_sopir' => 'required|string|max:255',
            'no_telp' => 'required|string|max:50',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try{  
            $sopir = Sopir::create([
                'nama_sopir' => $request->nama_sopir,
                'no_telp' => $request->no_telp,
                'status' => $request->status,
            ]);

            return response()->json(['message' => 'Sopir created successfully!', 'data' => $sopir], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Sopir created failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_sopir' => 'required|string|max:255',
            'no_telp' => 'required|string|max:50',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $sopir = Sopir::findOrFail($id);

            $sopir->update([
                'nama_sopir' => $request->nama_sopir,
                'no_telp' => $request->no_telp,
                'status' => $request->status,
            ]);

            return response()->json(['message' => 'Sopir updated successfully!', 'data' => $sopir], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Sopir updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

}