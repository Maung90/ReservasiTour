<?php

namespace App\Http\Controllers;
use App\Models\Produk; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Services\VendorService;
class ProdukController extends Controller
{
    protected $vendorService;
    function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }
    public function produk()
    {
        $vendors = $this->vendorService->getVendor();
        return view('produk.produk',compact('vendors'));
    }
    public function tableProduk() 
    {
        $produks = Produk::all();

        $data = DataTables::of($produks)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('nama_produk', function ($row) {
            return $row->nama_produk;
        })
        ->addColumn('harga', function ($row) {
            return $row->harga;
        })
        ->addColumn('area', function ($row) {
            return $row->area;
        })
        ->addColumn('tipe_produk', function ($row) {
            return $row->tipe_produk;
        })
        ->addColumn('action', function ($row) {
            $role_id = auth()->user()->role_id;

            $buttons = '<button type="button" class="capitalize btn btn-sm waves-effect waves-light btn-success info-btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#info-modal">
            <i class="ti ti-info-circle"></i>
            </button>';
            if ($role_id == 1 || $role_id == 2) {   
                $buttons .= '
                <button type="button" class="capitalize btn btn-sm waves-effect waves-light btn-warning edit-btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#edit-modal">
                <i class="ti ti-pencil"></i>
                </button>';
            }
            if ($role_id == 1) {   
                $buttons .= '<button type="button" class="btn btn-sm waves-effect waves-light btn-danger delete-btn" id="sa-confirm" data-id="'.$row->id.'">
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
        $produk = Produk::with(['vendor','creator','updator'])->find($id);

        return response()->json($produk);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        
        if ($produk) {
            $produk->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'area' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:50',
            'tipe_produk' => 'required|in:transport, hotel, restaurant, tourist_attraction, etc',
            'vendor_id' => 'required|exists:vendors,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try{  
            $produk = Produk::create([
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'area' => $request->area,
                'vendor_id' => $request->vendor_id,
                'tipe_produk' => $request->tipe_produk,
                'deskripsi' => $request->deskripsi,
            ]);

            return response()->json(['message' => 'Produk created successfully!', 'data' => $produk], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Produk created failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'area' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:50',
            'tipe_produk' => 'required',
            'vendor_id' => 'required|exists:vendors,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $produk = Produk::findOrFail($id);

            $produk->update([
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'area' => $request->area,
                'vendor_id' => $request->vendor_id,
                'tipe_produk' => $request->tipe_produk,
                'deskripsi' => $request->deskripsi,
            ]);

            return response()->json(['message' => 'Produk updated successfully!', 'data' => $produk], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Produk updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

}