<?php
namespace App\Services;

use App\Models\Tagihan;
use App\Models\Reservasi;
use Illuminate\Support\Facades\DB;
class DashboardService
{
    protected $userId,$role;

    public function __construct()
    {
        $this->userId = auth()->id();
        $this->role = auth()->user()->role_id;
    }

    public function getDashboardStats()
    {
        return [
            'reservasi_count' => $this->getReservasiCount(30),
            'paket_count' => $this->getPaketCount(30),
            'custom_count' => $this->getCustomCount(30),
            'paid_count' => $this->getPaidCount(30),
            'nonpaid_count' => $this->getNonPaidCount(30),
            'persentasePerWeek' => $this->getPersentase(7, 7, 'days'),
            'persentasePerYears' => $this->getPersentase(1, 1, 'years'),
            'totalProgram' => $this->getProgram(),
            'totalProduct' => $this->getProduct(),
        ];
    }

    private function getReservasiCount($days)
    {
        return Reservasi::forRole($this->userId, $this->role)->where('created_at', '>=', now()->subDays($days))
        ->count();
    }

    private function getPaketCount($days)
    {
        return Reservasi::forRole($this->userId, $this->role)->where('created_at', '>=', now()->subDays($days))
        ->whereNotNull('program_id')
        ->count();
    }

    private function getCustomCount($days)
    {
        return Reservasi::forRole($this->userId, $this->role)->where('created_at', '>=', now()->subDays($days))
        ->whereNull('program_id')
        ->count();
    }

    private function getPaidCount($days)
    {
        return Tagihan::join('reservasis', 'reservasis.id', '=', 'tagihans.reservasi_id')
        ->where('tagihans.created_at', '>=', now()->subDays($days))
        ->where('tagihans.status', 'paid')
        ->forRoleReservasi($this->userId, $this->role)
        ->sum('tagihans.total');
    }

    private function getNonPaidCount($days)
    {
        return Tagihan::join('reservasis', 'reservasis.id', '=', 'tagihans.reservasi_id')
        ->where('tagihans.created_at', '>=', now()->subDays($days))
        ->where('tagihans.status', '!=', 'paid')
        ->forRoleReservasi($this->userId, $this->role)
        ->count();
    }

    private function getPersentase($currentPeriod, $previousPeriod, $unit = 'days')
    {
        $queryMethod = match ($unit) {
            'days' => 'subDays',
            'months' => 'subMonths',
            'years' => 'subYears',
            default => throw new InvalidArgumentException("Unit $unit tidak valid."),
        };

        $reservations_current = Reservasi::where('created_at', '>=', now()->$queryMethod($currentPeriod))
        ->forRole($this->userId, $this->role)
        ->count();

        $reservations_previous = Reservasi::whereBetween('created_at', [
            now()->$queryMethod($currentPeriod + $previousPeriod), 
            now()->$queryMethod($currentPeriod),
        ])
        ->forRole($this->userId, $this->role)
        ->count();

        if ($reservations_previous > 0) {
            $increase = $reservations_current - $reservations_previous;
            return round(($increase / $reservations_previous) * 100, 2);
        }

        return ($reservations_current > 0) ? 100 : 0;
    }


    private function getProgram()
    {
        return DB::table('programs')->count();
    }
    private function getProduct()
    {
        return DB::table('produks')->count();
    }

}
