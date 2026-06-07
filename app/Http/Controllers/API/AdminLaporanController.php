<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
{
    $restaurant = $request->user()->restaurant;

    if (!$restaurant) {
        return response()->json(['success' => false, 'message' => 'Restoran tidak ditemukan.'], 404);
    }

    // ==========================================
    // TANGKAP FILTER TANGGAL DARI FRONTEND
    // ==========================================
    // Jika ada request start_date dan end_date, gunakan itu. Jika tidak, gunakan default bulan ini.
    $startDateStr = $request->query('start_date');
    $endDateStr = $request->query('end_date');

    if ($startDateStr && $endDateStr) {
        $startDate = Carbon::parse($startDateStr)->startOfDay();
        $endDate = Carbon::parse($endDateStr)->endOfDay();
    } else {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    }

    // ==========================================
    // 1. STATISTIK KARTU (Sesuai Filter Tanggal)
    // ==========================================
    $resThisPeriod = DB::table('reservations')
        ->where('restaurant_id', $restaurant->id)
        ->whereBetween('reservation_date', [$startDate->toDateString(), $endDate->toDateString()])
        ->get();

    $totalResThis = $resThisPeriod->count();

    $successStatuses = ['completed', 'Selesai', 'Hadir', 'confirmed'];
    $cancelStatuses = ['cancelled', 'Batal', 'canceled'];

    $guestsThis = $resThisPeriod->whereIn('status', $successStatuses)->sum('guests');
    $incomeThis = $resThisPeriod->whereIn('status', $successStatuses)->sum('total_price');
    $cancelThis = $resThisPeriod->whereIn('status', $cancelStatuses)->count();

    $stats = [
        'totalReservasi' => ['value' => number_format($totalResThis, 0, ',', '.')],
        'tamuTerlayani'  => ['value' => number_format($guestsThis, 0, ',', '.')],
        'pendapatan'     => ['value' => 'Rp ' . number_format($incomeThis, 0, ',', '.')],
        'pembatalan'     => ['value' => number_format($cancelThis, 0, ',', '.')]
    ];

    // ==========================================
    // 2. TREN RESERVASI HARIAN (7 Hari Terakhir dari End Date)
    // ==========================================
    $chartData = [];
    $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
    
    // Agar grafiknya rapi, kita ambil 7 hari mundur dari tanggal "Sampai" (endDate)
    $startOfWeek = $endDate->copy()->subDays(6); 
    
    $dailyRes = DB::table('reservations')
        ->where('restaurant_id', $restaurant->id)
        ->whereBetween('reservation_date', [$startOfWeek->toDateString(), $endDate->toDateString()])
        ->select(DB::raw('DATE(reservation_date) as date'), DB::raw('count(*) as total'))
        ->groupBy('date')
        ->get()->keyBy('date');

    for ($i = 6; $i >= 0; $i--) {
        $date = $endDate->copy()->subDays($i);
        $dateStr = $date->toDateString();
        $chartData[] = [
            'day' => $days[$date->dayOfWeek],
            'count' => isset($dailyRes[$dateStr]) ? $dailyRes[$dateStr]->total : 0
        ];
    }
    
    $maxChartVal = max(array_column($chartData, 'count'));
    if ($maxChartVal == 0) $maxChartVal = 1; 
    foreach ($chartData as &$cd) {
        $cd['percentage'] = round(($cd['count'] / $maxChartVal) * 100);
    }

    // ==========================================
    // 3. DISTRIBUSI AREA (Sesuai Filter Tanggal)
    // ==========================================
    $areaDistRaw = DB::table('reservations')
        ->join('tables', 'reservations.table_id', '=', 'tables.id')
        ->where('reservations.restaurant_id', $restaurant->id)
        ->whereBetween('reservations.reservation_date', [$startDate->toDateString(), $endDate->toDateString()])
        ->select('tables.area', DB::raw('count(*) as total'))
        ->groupBy('tables.area')
        ->get();

    $totalAreaRes = $areaDistRaw->sum('total');
    if ($totalAreaRes == 0) $totalAreaRes = 1;
    $colors = ['bg-[#50281A]', 'bg-[#1E524C]', 'bg-[#A68A80]', 'bg-[#D6C2BC]', 'bg-[#84746E]'];
    
    $areaDist = $areaDistRaw->map(function($item, $key) use ($totalAreaRes, $colors) {
        return [
            'name' => $item->area ?? 'Area Lain',
            'percentage' => round(($item->total / $totalAreaRes) * 100),
            'color' => $colors[$key % count($colors)]
        ];
    });

    // ==========================================
    // 4. DATA RESERVASI TERBARU (Sesuai Filter Tanggal)
    // ==========================================
    $recentRes = DB::table('reservations')
        ->leftJoin('tables', 'reservations.table_id', '=', 'tables.id')
        ->where('reservations.restaurant_id', $restaurant->id)
        ->whereBetween('reservations.reservation_date', [$startDate->toDateString(), $endDate->toDateString()])
        ->orderBy('reservations.created_at', 'desc')
        ->limit(100) // Diperbesar limitnya agar PDF/Excel bisa ekspor banyak data
        ->select('reservations.*', 'tables.area')
        ->get();

    $formattedRes = $recentRes->map(function($res) {
        $statusFront = 'Menunggu';
        if (in_array(strtolower($res->status), ['completed', 'selesai'])) $statusFront = 'Selesai';
        if (in_array(strtolower($res->status), ['confirmed', 'hadir'])) $statusFront = 'Hadir';
        if (in_array(strtolower($res->status), ['cancelled', 'batal', 'canceled'])) $statusFront = 'Batal';

        $dateObj = Carbon::parse($res->reservation_date);
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];

        return [
            'id' => '#RES-' . str_pad($res->id, 4, '0', STR_PAD_LEFT),
            'name' => $res->customer_name,
            'datetime' => $dateObj->day . ' ' . $months[$dateObj->month - 1] . ', ' . Carbon::parse($res->reservation_time)->format('H:i'),
            'pax' => $res->guests,
            'area' => $res->area ?? 'Belum Pilih Meja',
            'status' => $statusFront
        ];
    });

    return response()->json([
        'success' => true,
        'stats' => $stats,
        'chartData' => $chartData,
        'areaDist' => $areaDist,
        'reservations' => $formattedRes, 
        'user_name' => $request->user()->name, 
        'restaurant_name' => $restaurant->name
    ], 200);
}

    

    
}