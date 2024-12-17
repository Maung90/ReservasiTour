<?php

namespace App\Http\Controllers;
use App\Models\Program; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProgramController extends Controller
{
    public function program()
    {
        return view('program.program');
    }
    public function tableProgram() 
    {
        $programs = Program::all();

        $data = DataTables::of($programs)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('nama_program', function ($row) {
            return $row->nama_program;
        })
        ->addColumn('deskripsi', function ($row) {
            return $row->deskripsi;
        })
        ->addColumn('durasi', function ($row) {
            return $row->durasi;
        })
        ->addColumn('created_by', function ($row) {
            return $row->created_by;
        })
        ->addColumn('updated_by', function ($row) {
            return $row->updated_by;
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
        $program = Program::find($id);

        return response()->json($program);
    }

    public function destroy($id)
    {
        $program = Program::find($id);
        
        if ($program) {
            $program->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:50',
            'durasi' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try{  
            $program = Program::create([
                'nama_program' => $request->nama_program,
                'deskripsi' => $request->deskripsi,
                'durasi' => $request->durasi,
                'created_by' => "1",
                'updated_by' => "1",
            ]);

            return response()->json(['message' => 'Program created successfully!', 'data' => $program], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Program created failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:50',
            'durasi' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $program = Program::findOrFail($id);

            $program->update([
                'nama_program' => $request->nama_program,
                'deskripsi' => $request->deskripsi,
                'durasi' => $request->durasi,
                'created_by' => "1",
                'updated_by' => "1",
            ]);

            return response()->json(['message' => 'Program updated successfully!', 'data' => $program], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Program updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

}