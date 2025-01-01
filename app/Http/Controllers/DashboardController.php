<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $userId =  Auth::id();
        if ($userId == 1) {
            return view('dashboard.admin');
        }elseif ($userId == 2) {
            return view('dashboard.production');
        }elseif ($userId == 3) {
            return view('dashboard.operation');
        }elseif ($userId == 4) {
            return view('dashboard.accounting');
        }elseif ($userId == 5) {
            return view('dashboard.agent');
        }else{
            return view('dashboard.agent');
        }
    }
}
