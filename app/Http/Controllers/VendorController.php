<?php

namespace App\Http\Controllers;
use App\Models\Vendor; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class VendorController extends Controller
{
    public function vendor()
    {
        return view('vendor.vendor');
    }
    public function tableVendor() 
    {
        $vendors = Vendor::all();

        return DataTables::of($vendors)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('nama_vendor', function ($row) {
            return $row->nama_vendor;
        })
        ->addColumn('contact', function ($row) {
            return $row->contact;
        })
        ->addColumn('bank', function ($row) {
            return $row->bank;
        })
        ->addColumn('validity_period', function ($row) {
            return Carbon::parse($row->validity_period)->format('d F Y');
        })
        ->addColumn('action', function ($row) {
            return '
            <button type="button" class="capitalize btn btn-sm waves-effect waves-light btn-success info-btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#info-modal">
            <i class="ti ti-info-circle"></i>
            </button>
            <button type="button" class="capitalize btn btn-sm waves-effect waves-light btn-warning edit-btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-modal">
            <i class="ti ti-pencil"></i>
            </button>
            <button type="button" class="btn btn-sm waves-effect waves-light btn-danger delete-btn" id="sa-confirm" data-id="'.$row->id.'">
            <i class="ti ti-trash"></i>
            </button>
            ';

        })
            ->rawColumns(['action'])
        ->make(true);
    }

    public function get($id)
    {
        $vendor = Vendor::find($id);

        return response()->json($vendor);
    }

    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        
        if ($vendor) {
            $vendor->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_vendor' => 'required|string|max:255',
            'contact' => 'required|string|max:50',
            'bank' => 'required|string|max:255',
            'no_rekening' => 'required|numeric|digits_between:15,20',
            'account_name' => 'required|string|max:255',
            'validity_period' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try{  
            $vendor = Vendor::create([
                'nama_vendor' => $request->nama_vendor,
                'contact' => $request->contact,
                'bank' => $request->bank,
                'no_rekening' => $request->no_rekening,
                'account_name' => $request->account_name,
                'validity_period' => $request->validity_period,
            ]);

            return response()->json(['message' => 'Vendor created successfully!', 'data' => $vendor], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'File updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_vendor' => 'required|string|max:255',
            'contact' => 'required|string|max:50',
            'bank' => 'required|string|max:255',
            'no_rekening' => 'required|numeric|digits_between:15,20',
            'account_name' => 'required|string|max:255',
            'validity_period' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $vendor = Vendor::findOrFail($id);

            $vendor->update([
                'nama_vendor' => $request->nama_vendor,
                'contact' => $request->contact,
                'bank' => $request->bank,
                'no_rekening' => $request->no_rekening,
                'account_name' => $request->account_name,
                'validity_period' => $request->validity_period,
            ]);

            return response()->json(['message' => 'Vendor updated successfully!', 'data' => $vendor], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'File updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

}