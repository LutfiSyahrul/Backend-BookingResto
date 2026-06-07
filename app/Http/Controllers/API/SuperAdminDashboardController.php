<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Reservation;
use App\Models\ActivityLog;
use Carbon\Carbon;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $thisMonth = clone $now;
        $lastMonth = $now->copy()->subMonth();

        // --- 1. TOTAL RESTORAN ---
        $restoThisMonth = Restaurant::whereMonth('created_at', $thisMonth->month)->whereYear('created_at', $thisMonth->year)->count();
        $restoLastMonth = Restaurant::whereMonth('created_at', $lastMonth->month)->whereYear('created_at', $lastMonth->year)->count();
        $totalResto = Restaurant::count();
        $restoGrowth = $this->calculateGrowth($restoThisMonth, $restoLastMonth);

        // --- 2. TOTAL USER ---
        $usersThisMonth = User::where('role', '!=', 'superadmin')->whereMonth('created_at', $thisMonth->month)->count();
        $usersLastMonth = User::where('role', '!=', 'superadmin')->whereMonth('created_at', $lastMonth->month)->count();
        $totalUser = User::where('role', '!=', 'superadmin')->count();
        $userGrowth = $this->calculateGrowth($usersThisMonth, $usersLastMonth);

        // 3. TOTAL TRANSAKSI (Reservasi) 
        $transThisMonth = Reservation::whereMonth('created_at', $thisMonth->month)->count();
        $transLastMonth = Reservation::whereMonth('created_at', $lastMonth->month)->count();
        $totalTrans = Reservation::count();
        $transGrowth = $this->calculateGrowth($transThisMonth, $transLastMonth);

        // TOTAL PENDAPATAN (Dari Reservasi Selesai/Hadir) 
        $successStatuses = ['confirmed', 'completed', 'done', 'Done', 'success', 'berhasil', 'dine_in', 'Selesai', 'Hadir'];
        $revThisMonth = Reservation::whereIn('status', $successStatuses)->whereMonth('created_at', $thisMonth->month)->sum('total_price');
        $revLastMonth = Reservation::whereIn('status', $successStatuses)->whereMonth('created_at', $lastMonth->month)->sum('total_price');
        $totalRev = Reservation::whereIn('status', $successStatuses)->sum('total_price');
        $revGrowth = $this->calculateGrowth($revThisMonth, $revLastMonth);

        // ==========================================================
        // 5. AKTIVITAS TERBARU
        // ==========================================================
        $recentActivities = ActivityLog::orderBy('created_at', 'desc')->limit(10)->get()->map(function($log) {
            return [
                'id' => $log->id,
                'nama' => $log->subject_name,
                'sub' => $log->subject_type,
                'tipe' => $log->activity_type,
                'tanggal' => Carbon::parse($log->created_at)->translatedFormat('d M, H:i') . ' WIB',
                'status' => $log->status,
            ];
        });

        if ($recentActivities->isEmpty()) {
            $recentActivities = [
                ['id' => 1, 'nama' => 'Sistem Utama', 'sub' => 'Inisialisasi', 'tipe' => 'System Update', 'tanggal' => 'Hari Ini', 'status' => 'Verified']
            ];
        }

        // ==========================================================
        // 6. TREN PENDAPATAN BULANAN (12 Bulan Tahun Ini) 
        // ==========================================================
        $chartRevenue = [];
        $monthsLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        for ($m = 1; $m <= 12; $m++) {
            $revenue = Reservation::whereIn('status', $successStatuses)
                ->whereYear('created_at', $thisMonth->year)
                ->whereMonth('created_at', $m)
                ->sum('total_price');
            
            $chartRevenue[] = [
                'label' => $monthsLabel[$m - 1],
                'value' => (float) $revenue
            ];
        }

        // ==========================================================
        // 7. PERTUMBUHAN RESTORAN (6 Kuartal Terakhir)
        // ==========================================================
        $chartGrowth = [];
        
        // Map angka kuartal ke nama bulan agar sangat mudah dibaca awam
        $quarterNames = [
            1 => 'Jan-Mar',
            2 => 'Apr-Jun',
            3 => 'Jul-Sep',
            4 => 'Okt-Des'
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subQuarters($i);
            $quarter = ceil($date->month / 3);
            $year = $date->year;

            // Format akhirnya akan menjadi seperti: "Jan-Mar '26"
            $readableLabel = $quarterNames[$quarter] . " '" . substr($year, -2);

            $count = Restaurant::whereYear('created_at', $year)
                ->whereRaw('QUARTER(created_at) = ?', [$quarter])
                ->count();

            $chartGrowth[] = [
                'label' => $readableLabel, // <-- Memasukkan label yang sudah diformat
                'count' => $count,
                'current' => ($quarter == ceil(Carbon::now()->month / 3) && $year == Carbon::now()->year)
            ];
        }

        $maxGrowthCount = max(array_column($chartGrowth, 'count')) ?: 1;
        foreach ($chartGrowth as &$bar) {
            $bar['h'] = round(($bar['count'] / $maxGrowthCount) * 100) . '%';
        }

        // ==========================================================
        // RETURN FINAL (KIRIM SEMUA DATA KE NEXT.JS)
        // ==========================================================
        return response()->json([
            'success' => true,
            'data' => [
                'stats' => [
                    'restoran' => ['total' => $totalResto, 'growth' => $restoGrowth],
                    'user' => ['total' => $this->formatK($totalUser), 'growth' => $userGrowth],
                    'transaksi' => ['total' => $this->formatK($totalTrans), 'growth' => $transGrowth],
                    'pendapatan' => ['total' => $this->formatMoney($totalRev), 'growth' => $revGrowth],
                ],
                'activities' => $recentActivities,
                'chartRevenue' => $chartRevenue, 
                'chartGrowth' => $chartGrowth   
            ]
        ], 200);
    }

    // --- FUNGSI HELPER SAKTI ---
    private function calculateGrowth($current, $previous)
    {
        if ($previous == 0) return $current > 0 ? 100.0 : 0.0;
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function formatK($number)
    {
        if ($number >= 1000) return round($number / 1000, 1) . 'k';
        return $number;
    }

    private function formatMoney($number)
    {
        if ($number >= 1000000000) return 'Rp ' . round($number / 1000000000, 1) . ' Miliar';
        if ($number >= 1000000) return 'Rp ' . round($number / 1000000, 1) . ' Juta';
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}