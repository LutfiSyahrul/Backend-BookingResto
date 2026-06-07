<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation; // <-- Pastikan nama Model Reservasi bos sesuai
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data admin yang sedang login beserta restorannya
        $user = $request->user();
        $restaurant = $user->restaurant;

        if (!$restaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Akun admin ini belum terhubung dengan restoran manapun.'
            ], 404);
        }

        $restaurantId = $restaurant->id;
        $today = Carbon::today()->format('Y-m-d');

        // 2. HITUNG STATISTIK UTAMA (Khusus Restoran Ini)
        
        // A. Total Reservasi Hari Ini
        $reservationsToday = DB::table('reservations')
            ->where('restaurant_id', $restaurantId)
            ->whereDate('reservation_date', $today)
            ->count();

        // B. Meja Aktif (Menghitung meja unik yang status reservasinya sedang 'confirmed' atau 'dine_in' hari ini)
        $activeTables = DB::table('reservations')
            ->where('restaurant_id', $restaurantId)
            ->whereDate('reservation_date', $today)
            ->whereIn('status', ['confirmed', 'dine_in'])
            ->distinct('table_id') // Anggap nama kolomnya table_id
            ->count();

        // C. Total Pengunjung Hari Ini (Sum dari kolom jumlah orang / guests)
        $totalGuests = DB::table('reservations')
            ->where('restaurant_id', $restaurantId)
            ->whereDate('reservation_date', $today)
            ->sum('guests'); // Sesuaikan nama kolom jumlah orang di tabel reservasi bos

        // 3. AMBIL RECENT BOOKINGS (5 Reservasi Terbaru Hari Ini)
        $recentBookings = DB::table('reservations')
            ->leftJoin('tables', 'reservations.table_id', '=', 'tables.id') 
            ->where('reservations.restaurant_id', $restaurantId)
            ->select(
                'reservations.id',
                'reservations.customer_name', // Langsung pakai nama kolom asli
                'reservations.guests',
                'tables.area', // Ambil area meja
                'reservations.reservation_time',
                'reservations.created_at',
                'reservations.status'
            )
            ->orderBy('reservations.created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'customer_name' => $booking->customer_name,
                    'guests' => $booking->guests,
                    'area' => $booking->area ?? 'Belum Pilih Meja',
                    'reservation_time' => Carbon::parse($booking->reservation_time)->format('H:i'),
                    'status' => $booking->status // Kembalikan status aslinya (bukan waktu created_at)
                ];
            });

        // 4. DATA TREN HARIAN (Format Khusus Frontend: count & percentage)
        $chartData = [];
        $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $startOfWeek = Carbon::now()->subDays(6); // Ambil 7 hari terakhir biar padat grafiknya
        
        $dailyRes = DB::table('reservations')
            ->where('restaurant_id', $restaurantId)
            ->whereDate('reservation_date', '>=', $startOfWeek)
            ->select(DB::raw('DATE(reservation_date) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->get()->keyBy('date');

        // Looping mundur dari 6 hari lalu sampai hari ini
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateStr = $date->toDateString();
            $chartData[] = [
                'day' => $days[$date->dayOfWeek],
                'count' => isset($dailyRes[$dateStr]) ? $dailyRes[$dateStr]->total : 0
            ];
        }
        
        // Kalkulasi persentase tinggi batang (0-100%)
        $maxChartVal = max(array_column($chartData, 'count'));
        if ($maxChartVal == 0) $maxChartVal = 1; 
        foreach ($chartData as &$cd) {
            $cd['percentage'] = round(($cd['count'] / $maxChartVal) * 100);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Dashboard Berhasil Dimuat',
            'restaurant_name' => $restaurant->name,
            'data' => [
                'stats' => [
                    'reservations_today' => $reservationsToday,
                    'active_tables' => $activeTables,
                    'total_guests' => (int)$totalGuests,
                ],
                'recent_bookings' => $recentBookings,
                'chart_data' => $chartData 
            ]
        ], 200);
    }
}