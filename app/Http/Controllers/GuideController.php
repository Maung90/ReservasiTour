<?php

namespace App\Http\Controllers;
use App\Models\Guide; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class GuideController extends Controller
{
    public function guide()
    {
        return view('guide.guide');
    }
    public function tableguide() 
    {
        $guides = Guide::all();

        $data = DataTables::of($guides)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('nama_guide', function ($row) {
            return $row->nama_guide;
        })
        ->addColumn('no_telp', function ($row) {
            return $row->no_telp;
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
        $guide = Guide::find($id);

        return response()->json($guide);
    }

    public function destroy($id)
    {
        $guide = Guide::find($id);
        
        if ($guide) {
            $guide->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_guide' => 'required|string|max:255',
            'no_telp' => ['required','unique:Guides','string','max:25','regex:/^\+?[0-9]{10,15}$/',],
            'status' => 'required|in:available,unavailable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try{  
            $guide = Guide::create([
                'nama_guide' => $request->nama_guide,
                'no_telp' => $request->no_telp,
                'status' => $request->status,
            ]);

            return response()->json(['message' => 'Guide created successfully!', 'data' => $guide], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Guide created failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_guide' => 'required|string|max:255',
            'no_telp' => ['required','unique:Guides','string','max:25','regex:/^\+?[0-9]{10,15}$/',],
            'status' => 'required|in:available,unavailable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $guide = Guide::findOrFail($id);

            $guide->update([
                'nama_guide' => $request->nama_guide,
                'no_telp' => $request->no_telp,
                'status' => $request->status,
            ]);

            return response()->json(['message' => 'Guide updated successfully!', 'data' => $guide], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Guide updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

}