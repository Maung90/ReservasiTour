<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\DashboardService;
use App\Models\Reservasi;
use App\Models\Tagihan;

use App\Services\ReservasiService;
use App\Services\BahasaService;
use App\Services\SopirService;
use App\Services\GuideService;
use App\Services\ProgramService;
use App\Services\KendaraanService;

class DashboardController extends Controller
{    
    protected $userId,$role;

    public function __construct(BahasaService $bahasaService, SopirService $sopirService, GuideService $guideService, ProgramService $programService, KendaraanService $kendaraanService, DashboardService $dashboardService ,ReservasiService $reservasiService)
    {
        $this->dashboardService = $dashboardService;
        $this->userId = auth()->id();
        $this->role = auth()->user()->role_id;
        $this->bahasaService = $bahasaService;
        $this->sopirService = $sopirService;
        $this->guideService = $guideService;
        $this->programService = $programService;
        $this->kendaraanService = $kendaraanService;
        $this->reservasiService = $reservasiService;

    }

    public function dashboard()
    {
        $userId = auth()->user()->role_id;
        $role = '';
        $statistik = $this->dashboardService->getDashboardStats();
        if ($userId == 1) {
            $role = 'admin';
        }elseif ($userId == 2) {
            $role = 'production';
        }elseif ($userId == 3) {

            $bahasas = $this->bahasaService->getBahasa();
            $guides = $this->guideService->getGuide();
            $sopirs = $this->sopirService->getSopir();
            $programs = $this->programService->getProgram();
            $kendaraans = $this->kendaraanService->getKendaraan();
            $role = 'operation';

            return view('dashboard.operation',compact('bahasas','guides', 'sopirs', 'programs', 'kendaraans'));
        }elseif ($userId == 4) {
            $role = 'accounting';
        }elseif ($userId == 5) {
            $role = 'agent';
        }else{
            $role = 'agent';
        }
        return view('dashboard.'.$role, compact(['statistik']));
    }

    public function getAgentWeekChart()
    {
        $userId = auth()->id(); 

        $week = DB::table('reservasis')
        ->selectRaw('DATE(created_at) as date, COUNT(*) as reservations_count')
        ->where('created_at', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 7 DAY)'))
        ->where('created_by', $userId)
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date', 'ASC')
        ->get();
        $formattedData = $week->map(function ($item) {
            return [
                'date' => $item->date,
                'reservations_count' => $item->reservations_count,
            ];
        });

        return response()->json($formattedData);
    }

    public function getAgentYearChart()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $months = collect(range(1, 12))->map(function ($i) use ($currentMonth, $currentYear) {
            $month = ($currentMonth - 12 + $i) % 12;
            $month = $month === 0 ? 12 : $month;
            $year = $currentYear - (($currentMonth - 12 + $i) <= 0 ? 1 : 0);
            $monthName = date('M', mktime(0, 0, 0, $month, 1));
            return [
                'month' => $month,
                'year' => $year,
                'label' => $monthName,
                'reservations_count' => 0,
            ];
        });

        $dbData = Reservasi::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as reservations_count')
        ->forRole($this->userId, $this->role)
        ->whereBetween('created_at', [now()->subMonths(11)->startOfMonth(), now()->endOfMonth()])
        ->groupBy('month', 'year')
        ->get();

        $result = $months->map(function ($month) use ($dbData) {
            $data = $dbData->firstWhere('month', $month['month']);
            $month['reservations_count'] = $data ? $data->reservations_count : 0;
            return $month;
        });

        return response()->json($result);
    }

    public function getTopProgram()
    {
        $topPrograms = DB::table('reservasis')
        ->select('programs.nama_program as program_name', DB::raw('COUNT(reservasis.id) as reservations_count'))
        ->join('programs', 'programs.id', '=', 'reservasis.program_id')
        ->where('reservasis.created_at', '>=', now()->subDays(30))
        ->groupBy('programs.id', 'programs.nama_program')
        ->orderBy('reservations_count', 'desc')
        ->limit(5)
        ->get();

        return response()->json($topPrograms);
    }
    
    public function getDailyIncome($days)
    {
        $dailyIncome = Tagihan::join('reservasis', 'reservasis.id', '=', 'tagihans.reservasi_id')
        ->where('tagihans.created_at', '>=', now()->subDays($days))
        ->where('tagihans.status', 'paid')
        ->forRoleReservasi($this->userId, $this->role)
        ->selectRaw('DATE(tagihans.created_at) as date, SUM(tagihans.total) as total_income')
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        return response()->json($dailyIncome);
    }

}
