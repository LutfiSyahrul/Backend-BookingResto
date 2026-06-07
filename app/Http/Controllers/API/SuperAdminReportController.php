<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SuperAdminReportController extends Controller
{
    public function getAnalytics(Request $request)
    {
        $filter = $request->filter;

        // TENTUKAN RENTANG WAKTU BERDASARKAN FILTER
        if ($filter == 'Tahun Ini') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif ($filter == 'Custom' && $request->has('start_date') && $request->has('end_date')) {
            // TANGKAP TANGGAL DARI DATE PICKER NEXT.JS
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
        } else {
            // Default: Bulan Ini
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        // Ambil SEMUA transaksi BERHASIL di rentang waktu tersebut
        $successfulTrx = Reservation::with('restaurant')
            ->whereIn('status', ['confirmed', 'completed', 'done', 'success']) 
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // =========================================================================
        // 1. DATA TREN & TABEL (Otomatis: Harian untuk Bulan/Custom, Bulanan untuk Tahun)
        // =========================================================================
        
        // A. Tentukan format *grouping* berdasarkan filter
        if ($filter == 'Tahun Ini') {
            // Jika Tahun Ini: Kelompokkan per BULAN (Jan, Feb, Mar...) -> Hanya 12 titik
            $groupFormat = 'Y-m';
            $displayFormat = 'M Y'; // Contoh hasil: Jan 2026
            $period = \Carbon\CarbonPeriod::create($startDate, '1 month', $endDate);
        } else {
            // Jika Bulan Ini / Custom: Kelompokkan per HARI -> Maksimal 31 titik
            $groupFormat = 'Y-m-d';
            $displayFormat = 'd M Y'; // Contoh hasil: 01 May 2026
            $period = \Carbon\CarbonPeriod::create($startDate, '1 day', $endDate);
        }

        // B. Kelompokkan data dari Database sesuai format yang disepakati di atas
        $groupedTrx = $successfulTrx->groupBy(function($date) use ($groupFormat) {
            return Carbon::parse($date->created_at)->format($groupFormat);
        });

        $dailyData = collect();

        // C. Looping rentang kalender (12 Bulan atau 31 Hari) dan isi angka 0 jika kosong
        foreach ($period as $date) {
            $dateString = $date->format($groupFormat);
            $displayDate = $date->translatedFormat($displayFormat); 

            if ($groupedTrx->has($dateString)) {
                $rows = $groupedTrx->get($dateString);
                $dailyData->push([
                    'date' => $displayDate,
                    'transaksi' => $rows->count(),
                    'pendapatan' => $rows->sum('total_price')
                ]);
            } else {
                $dailyData->push([
                    'date' => $displayDate,
                    'transaksi' => 0,
                    'pendapatan' => 0
                ]);
            }
        }
        
        // =========================================================================
        // 2. DATA TOP 5 RESTORAN PALING LARIS
        // =========================================================================
        $colors = ["#50281A", "#9CA3AF", "#FDE68A", "#D6C2BC", "#E5E7EB"]; // Tema warna UI bosku
        
        $topResto = $successfulTrx->groupBy('restaurant_id')->map(function ($row) {
            return [
                'name' => $row->first()->restaurant ? $row->first()->restaurant->name : 'Restoran Dihapus',
                'value' => $row->count(),
            ];
        })->sortByDesc('value')->take(5)->values()->map(function ($item, $index) use ($colors) {
            $item['color'] = $colors[$index % count($colors)];
            return $item;
        });

        // =========================================================================
        // 3. DATA METODE PEMBAYARAN POPULER
        // =========================================================================
        $totalRevenue = $successfulTrx->sum('total_price');
        
        $paymentDataRaw = $successfulTrx->groupBy('payment_method')->map(function ($row, $key) use ($totalRevenue) {
            $amount = $row->sum('total_price');
            $percentage = $totalRevenue > 0 ? round(($amount / $totalRevenue) * 100) : 0;
            return [
                'method' => $key ?: 'Tunai / Manual',
                'raw_amount' => $amount,
                'amount' => 'Rp ' . number_format($amount, 0, ',', '.'),
                'percentage' => $percentage,
            ];
        })->sortByDesc('raw_amount')->values();

        // Berikan warna progress bar berdasarkan urutan
        $paymentColors = ["bg-[#50281A]", "bg-gray-400", "bg-[#D6C2BC]", "bg-[#E9E1DC]"];
        $paymentData = $paymentDataRaw->map(function ($item, $index) use ($paymentColors) {
            $item['color'] = $paymentColors[$index % count($paymentColors)];
            return $item;
        });

        // KEMBALIKAN SEMUA DATA KE FRONTEND
        return response()->json([
            'success' => true,
            'data' => [
                'trendData' => $dailyData,
                'topRestoData' => $topResto,
                'paymentData' => $paymentData,
                'tableData' => $dailyData->sortByDesc('date')->values() // Urutkan terbaru di atas untuk tabel
            ]
        ], 200);
    }
}