<?php

namespace App\Http\Controllers;
use App\Models\Tagihan; 

use Midtrans\Config;
use Midtrans\Snap;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function tagihan()
    {
        return view('tagihan.tagihan');
    }
    public function tableTagihan() 
    {
        $user = auth()->user();
        if ($user->role_id == 5) {
            $tagihans = Tagihan::with(['reservasi'])->where('created_by',$user->id)->orderBy('id', 'desc')->get();
        }else{
            $tagihans = Tagihan::with(['reservasi'])->orderBy('id', 'desc')->get();
        }
        return DataTables::of($tagihans)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('tour_code', function ($row) {
            return $row->reservasi->tour_code;
        })
        ->addColumn('total', function ($row) {
            return $row->total;
        })
        ->addColumn('status', function ($row) {
            $status = $row->status == "paid" ? " bg-success" : "bg-danger";
            return '<span class="badge rounded-pill '.$status.'">'.$row->status.'</span>';
        })
        ->addColumn('action', function ($row) use ($user){
            
            $buttons = '
            <button type="button" class="capitalize btn btn-sm waves-effect waves-light btn-success info-btn" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#info-modal">
            <i class="ti ti-info-circle"></i>
            </button>
            <a class="capitalize btn btn-sm waves-effect waves-light btn-primary pay-btn" href="'.route('tagihan.payment',$row->id).'">
            <i class="ti ti-credit-card"></i>
            </a>';
            if ($user->role_id == 4 || $user->role_id == 1) {
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
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function get($id)
    {
        $tagihan = Tagihan::find($id);

        return response()->json($tagihan);
    }

    public function destroy($id)
    {
        $tagihan = Tagihan::find($id);
        
        if ($tagihan) {
            $tagihan->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:paid,pending',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $tagihan = Tagihan::findOrFail($id);

            $tagihan->update([
                'status' => $request->status,
            ]);

            return response()->json(['message' => 'Tagihan updated successfully!', 'data' => $tagihan], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Tagihan updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function tagihanPayment($id)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        $tagihan = Tagihan::with(['creator','reservasi'])->findOrFail($id);

        $params = [
            'transaction_details' => [
                'order_id' => $tagihan->id,
                'gross_amount' => $tagihan->total, 
            ],
            'customer_details' => [
                'first_name' => $tagihan->creator->nama,
                'email' => $tagihan->creator->email,
                'phone' => $tagihan->creator->contact,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('tagihan.show', compact('snapToken','tagihan'));

        } catch (\Exception $e) {
            return view('tagihan.show', compact('tagihan'));
        }

    }

    public function handlePaymentCallback(Request $request)
    {

        $payload = $request->all();

        // $serverKey = config('midtrans.server_key');
        // $calculatedSignature = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $serverKey);
        
        // if ($calculatedSignature !== $payload['signature_key']) {
        //     return response()->json(['message' => 'Invalid signature'], 403);
        // }

        $tagihan = Tagihan::where('id', $payload['order_id'])->first();

        if (!$tagihan) {
            return response()->json(['message' => 'Tagihan not found'], 404);
        }

        if ($payload['transaction_status'] == 'settlement') {
            $tagihan->update(['status' => 'paid']);

        } elseif ($payload['transaction_status'] == 'pending') {
            $tagihan->update(['status' => 'pending']);

        } elseif ($payload['transaction_status'] == 'expire') {
            return response()->json(['message' => 'Transaction has expired'], 400);

        } elseif ($payload['transaction_status'] == 'cancel') {
            return response()->json(['message' => 'Transaction has canceled'], 400);

        }else{
            return response()->json(['message' => 'Unknown status'], 400);

        }

        return response()->json(['message' => 'Payment status received']);
    }

}
