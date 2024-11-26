<?php

namespace App\Http\Controllers;
use App\Models\User; 

use Illuminate\Http\Request;
use Illuminate\Support\Str;  
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    public function User()
    {
        return view('user.user');
    }
    public function tableUser() 
    {
        $users = User::with(['role'])->whereNot('role_id','1');

        $data = DataTables::of($users)
        ->addColumn('no', function ($row) {
            static $counter = 0;
            return ++$counter;
        })
        ->addColumn('nama', function ($row) {
            return $row->nama;
        })
        ->addColumn('email', function ($row) {
            return $row->email;
        })
        ->addColumn('username', function ($row) {
            return $row->username;
        })
        ->addColumn('role_id', function ($row) {
            return $row->role->role;
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
        $user = User::find($id);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'Data deleted successfully.']);
        } else {
            return response()->json(['message' => 'Data not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|unique:Users|string|max:255',
            'email' => 'required|unique:Users|email|max:255',
            'notelp' => ['required','unique:Users','string','max:25','regex:/^\+?[0-9]{10,15}$/',],
            'role' => 'required|in:2,3,4,5',
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
            $password = Str::random(10); 
            Mail::to($request->email)->send(new SendEmail($password));
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'username' => $request->username,
                'notelp' => $request->notelp,
                'role_id' => $request->role,
                'password' => $password,
            ]);

            return response()->json(['message' => 'User created successfully!', 'data' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User created failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required','string','max:255' ,Rule::unique('users')->ignore($id),],
            'username' => ['required','string','max:255', Rule::unique('users')->ignore($id),],
            'email' => ['required','email','max:255', Rule::unique('users')->ignore($id),],
            'notelp' => ['required','string','max:25','regex:/^\+?[0-9]{10,15}$/', Rule::unique('users')->ignore($id),],
            'role' => ['required','in:2,3,4,5'],
        ], [
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
            $user = User::findOrFail($id);

            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'username' => $request->username,
                'notelp' => $request->notelp,
                'role_id' => $request->role,
                'password' => '-',
            ]);

            return response()->json(['message' => 'User updated successfully!', 'data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User updated failed.', 'error' => $e->getMessage()], 500);
        }
    }

}
