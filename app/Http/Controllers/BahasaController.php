<?php

namespace App\Http\Controllers;
use App\Models\Bahasa; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BahasaController extends Controller
{
    public function bahasa()
    {
        return view('bahasa.bahasa');
    }
    public function tableBahasa() 
    {
        $bahasas = Bahasa::all();

        $data = DataTables::of($bahasas)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('nama_bahasa', function ($row) {
            return $row->nama_bahasa;
        })
        ->addColumn('harga_bahasa', function ($row) {
            return $row->harga_bahasa;
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
        $bahasa = Bahasa::find($id);

        return response()->json($bahasa);
    }

    public function destroy($id)
    {
        $bahasa = Bahasa::find($id);
        
        if ($bahasa) {
            $bahasa->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bahasa' => 'required|unique:bahasas|string|max:255',
            'harga_bahasa' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try{  
            $bahasa = Bahasa::create([
                'nama_bahasa' => $request->nama_bahasa,
                'harga_bahasa' => $request->harga_bahasa,
            ]);

            return response()->json(['message' => 'Bahasa created successfully!', 'data' => $bahasa], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Bahasa created failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_bahasa' => 'required|unique:bahasas|string|max:255',
            'harga_bahasa' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $bahasa = Bahasa::findOrFail($id);

            $bahasa->update([
                'nama_bahasa' => $request->nama_bahasa,
                'harga_bahasa' => $request->harga_bahasa,
            ]);

            return response()->json(['message' => 'Bahasa updated successfully!', 'data' => $bahasa], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Bahasa updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

}
