<?php

namespace App\Http\Controllers;
use App\Models\Guide; 
use App\Models\GuideHasBahasa; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Services\BahasaService;

class GuideController extends Controller
{
    protected $bahasaService;

    public function __construct(BahasaService $bahasaService)
    {
        $this->bahasaService = $bahasaService;
    }
    public function guide()
    {
        $bahasas = $this->bahasaService->getBahasa();
        return view('guide.guide',compact('bahasas'));
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
            $status = $row->status == "available" ? " bg-success" : "bg-danger";
            return '<span class="badge rounded-pill '.$status.'">'.$row->status.'</span>';
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

        })->rawColumns(['action','status'])
        ->make(true);

        return $data;
    }

    public function get($id)
    {
        $guide = Guide::with('bahasa.bahasa')->findOrFail($id);

        $bahasaIdList = $guide->bahasa->map(function ($item) {
            return $item->bahasa->id;
        })->filter()->toArray();


        $bahasaList = $guide->bahasa->map(function ($item) {
            return $item->bahasa->nama_bahasa ?? null;
        })->filter()->toArray();

        $bahasaHtml = '<ol class="p-0 m-0">';
        foreach ($bahasaList as $namaBahasa) {
            $bahasaHtml .= "<li>{$namaBahasa}</li>";
        }
        $bahasaHtml .= '</ol>';

        $data = [
            'id' => $guide->id,
            'no_telp' => $guide->no_telp,
            'nama_guide' => $guide->nama_guide,
            'status' => $guide->status,
            'bahasa' => $bahasaHtml,
            'bahasa_id' => $bahasaIdList,
        ];
        return response()->json($data);
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
            'bahasa' => 'required|array',
            'bahasa.*' => 'exists:bahasas,id',
        ],[
            'notelp.required' => 'Nomor telepon wajib diisi.',
            'notelp.regex' => 'Nomor telepon harus berupa angka dan memiliki panjang antara 10 hingga 15 digit.',
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
            try{ 
                foreach ($request->bahasa as $bhs) {
                    GuideHasBahasa::create([
                        'guide_id' => $guide->id,
                        'bahasa_id'=> $bhs
                    ]);
                }
                return response()->json(['message' => 'Guide created successfully!', 'data' => $guide], 201);
            }catch (\Exception $e) {
                return response()->json(['message' => 'Guide Has Bahasa created failed.', 'error' => $e->getMessage()], 500);
            }
            return response()->json(['message' => 'Guide created successfully!', 'data' => $guide], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Guide created failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_guide' => 'required|string|max:255',
            'no_telp' => ['required','string','max:25','regex:/^\+?[0-9]{10,15}$/', Rule::unique('Guides')->ignore($id),],
            'status' => 'required|in:available,unavailable',
        ],[
            'notelp.required' => 'Nomor telepon wajib diisi.',
            'notelp.regex' => 'Nomor telepon harus berupa angka dan memiliki panjang antara 10 hingga 15 digit.',
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
            try{  
                $existingBahasaIds = GuideHasBahasa::where('guide_id', $guide->id)->pluck('bahasa_id')->toArray();

                 // Bahasa yang dipilih oleh user
                $selectedBahasaIds = $request->bahasa;

                // Cari bahasa_id yang perlu dihapus (tidak ada di $selectedBahasaIds)
                $bahasaToRemove = array_diff($existingBahasaIds, $selectedBahasaIds);

                // Cari bahasa_id yang perlu ditambahkan (tidak ada di $existingBahasaIds)
                $bahasaToAdd = array_diff($selectedBahasaIds, $existingBahasaIds);

                // Hapus bahasa yang tidak lagi dipilih
                if (!empty($bahasaToRemove)) {
                    GuideHasBahasa::where('guide_id', $guide->id)
                    ->whereIn('bahasa_id', $bahasaToRemove)
                    ->delete();
                }

                // Tambahkan bahasa baru yang dipilih
                foreach ($bahasaToAdd as $bhs) {
                    GuideHasBahasa::create([
                        'guide_id' => $guide->id,
                        'bahasa_id' => $bhs,
                    ]);
                }

                return response()->json(['message' => 'Guide updated successfully!', 'data' => $guide], 201);
            }catch (\Exception $e) {
                return response()->json(['message' => 'Guide Has Bahasa updated failed.', 'error' => $e->getMessage()], 500);
            }
            return response()->json(['message' => 'Guide updated successfully!', 'data' => $guide], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Guide updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

}
?>