<?php

namespace App\Http\Controllers;
use App\Models\ReservasiActivities; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ActivityController extends Controller
{
    public function activity()
    {
        return view('activity.activity');
    }
    public function tableActivity() 
    {
        $activitys = ReservasiActivities::whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')->from('reservasi_activities')->groupBy('reservasi_id');
        })->with(['reservasi'])->get();

        return DataTables::of($activitys)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('tour_code', function ($row) {
            return $row->reservasi->tour_code;
        })
        ->addColumn('dob', function ($row) {
            return $row->reservasi->dob;
        })
        ->addColumn('tour_date', function ($row) {
            return $row->reservasi->tour_date;
        })
        ->addColumn('guest_name', function ($row) {
            return $row->reservasi->guest_name;
        })
        ->addColumn('contact', function ($row) {
            return $row->reservasi->contact;
        })
        ->addColumn('action', function ($row) {
            $role_id = auth()->user()->role_id;

            $buttons = '<button type="button" class="capitalize btn btn-sm waves-effect waves-light btn-success info-btn" data-id="'.$row->reservasi_id.'" data-bs-toggle="modal" data-bs-target="#info-modal"> <i class="ti ti-info-circle"></i></button>';
            if ($role_id == 1 || $role_id == 3) {   
                $buttons .= '
                <button type="button" class="capitalize btn btn-sm waves-effect waves-light btn-warning edit-btn" data-id="'.$row->reservasi_id.'" data-bs-toggle="modal" data-bs-target="#edit-modal"> <i class="ti ti-pencil"></i> </button>';
            }
            return $buttons;

        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function get($id)
    {
        $activity = ReservasiActivities::with(['reservasi'])->where('reservasi_id', $id)->get();
        $firstReservasi = $activity->first()?->reservasi;

        if (!$firstReservasi) {
            return response()->json(['error' => 'Reservasi tidak ditemukan'], 404);
        }

        $datas = $activity->map(function ($activity) use ($firstReservasi) {
            return [
                'tbody' => '<tr> <td>' . $firstReservasi->tour_code . '</td> <td>' . $activity->aktivitas . '</td><td>'. Carbon::parse($activity->waktu)->format('d F Y H:i:s').'</td> <td> <button type="button" class="btn btn-sm waves-effect waves-light btn-danger delete-btn"  id="sa-confirm" data-id="' . $activity->id . '"> <i class="ti ti-trash"></i> </button> </td> </tr>',
                'list' => '<ul> <li> &bull;&nbsp;&nbsp;&nbsp;' .$activity->aktivitas .'-'. Carbon::parse($activity->waktu)->format('d F Y H:i:s').'</li></ul>',
            ];
        });

        $arr = [
            'reservasi_id' => $firstReservasi->id ?? '',
            'tour_code' => $firstReservasi->tour_code ?? '',
            'tour_date' => $firstReservasi->tour_date ?? '',
            'dob' => $firstReservasi->dob ?? '',
            'guest_name' => $firstReservasi->guest_name ?? '',
            'contact' => $firstReservasi->contact ?? '',
            'activity' => $datas, 
        ];

        return response()->json($arr);
    }



    public function destroy($id)
    {
        $activity = ReservasiActivities::find($id);

        if ($activity) {
            $activity->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aktivitas' => 'required|string|max:255',
            'waktu' => 'required|date',
            'reservasi_id' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try{  
            $activity = ReservasiActivities::create([
                'aktivitas' => $request->aktivitas,
                'waktu' => $request->waktu,
                'reservasi_id' => $request->reservasi_id,
            ]);

            return response()->json(['message' => 'Vendor created successfully!', 'data' => $activity], 201);
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
            $activity = ReservasiActivities::findOrFail($id);

            $activity->update([
                'nama_vendor' => $request->nama_vendor,
                'contact' => $request->contact,
                'bank' => $request->bank,
                'no_rekening' => $request->no_rekening,
                'account_name' => $request->account_name,
                'validity_period' => $request->validity_period,
            ]);

            return response()->json(['message' => 'Vendor updated successfully!', 'data' => $activity], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'File updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

}