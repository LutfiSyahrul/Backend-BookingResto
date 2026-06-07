<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReservationController extends Controller
{
    // 1. Fungsi untuk mengambil data dengan Filter, Search, & Pagination
    public function index(Request $request)
    {
        $user = $request->user();
        $restaurant = $user->restaurant;

        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Restoran tidak ditemukan.'], 404);
        }

        // Mulai meracik Query ke tabel reservations
        $query = DB::table('reservations')
            ->leftJoin('tables', 'reservations.table_id', '=', 'tables.id')
            ->where('reservations.restaurant_id', $restaurant->id);

        // PERBAIKAN 1: Filter Tanggal Dinamis (Terima lemparan dari Next.js) 
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('reservations.reservation_date', $request->date);
        } else {
            $query->whereDate('reservations.reservation_date', Carbon::today());
        }

        $query->select(
            'reservations.id',
            'reservations.customer_name',
            'reservations.customer_phone',
            'reservations.reservation_time',
            'tables.name as table_name',
            'reservations.guests',
            'reservations.status'
        );

        // FITUR PROFESIONAL: Pencarian Nama (Live Search Server-side)
        if ($request->has('search') && $request->search != '') {
            $query->where('reservations.customer_name', 'like', '%' . $request->search . '%');
        }

        // FITUR PROFESIONAL: Filter Status
        if ($request->has('status') && $request->status != 'Semua Status') {
            if ($request->status == 'Menunggu') {
                // Tarik data yang belum bayar (pending) DAN yang sudah lunas (booked)
                $query->whereIn('reservations.status', ['pending', 'booked']);
            } else {
                $dbStatus = 'pending';
                if ($request->status == 'Checked-in') $dbStatus = 'dine_in'; 
                if ($request->status == 'Dibatalkan') $dbStatus = 'cancelled';
                
                $query->where('reservations.status', $dbStatus);
            }
        }

        // Eksekusi Query dengan Pagination (Bawaan Laravel)
        // Ambil per-page dari request Next.js, default 4 per halaman
        $perPage = $request->input('per_page', 4); 
        $reservations = $query->orderBy('reservations.reservation_time', 'asc')->paginate($perPage);

        // Format ulang data agar 100% cocok dengan struktur Frontend bos
        $formattedData = collect($reservations->items())->map(function ($res) {
            // Konversi bahasa Database ke bahasa Frontend
            $statusFront = 'Menunggu';
            if ($res->status == 'dine_in' || $res->status == 'confirmed') $statusFront = 'Checked-in';
            if ($res->status == 'cancelled') $statusFront = 'Dibatalkan';
            if ($res->status == 'completed') $statusFront = 'Selesai';

            // Ambil 2 huruf pertama dari nama untuk Inisial Logo
            $words = explode(' ', $res->customer_name);
            $initial = count($words) > 1 
                ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                : strtoupper(substr($res->customer_name, 0, 2));
            
            // Jika status pangkalan data masih 'pending', bermaksud belum bayar. Jika 'booked' dan ke atas, bermaksud lunas.
            $paymentStatus = ($res->status == 'pending') ? 'Belum Bayar' : 'Lunas';
            
            return [
                'id' => $res->id,
                'name' => $res->customer_name,
                'phone' => $res->customer_phone ?? '',
                'payment_status' => $paymentStatus,
                'time' => Carbon::parse($res->reservation_time)->format('H:i') . ' WIB',
                'table' => $res->table_name ?? '-',
                'pax' => $res->guests,
                'status' => $statusFront,
                'initial' => $initial
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedData,
            'pagination' => [
                'current_page' => $reservations->currentPage(),
                'last_page' => $reservations->lastPage(),
                'total_items' => $reservations->total(),
            ]
        ], 200);
    }

    // 2. Fungsi untuk Update Status (Check-in / Batalkan)
    public function updateStatus(Request $request, $id)
    {
        // 1. Tambahkan 'checkout' di validasi
        $request->validate([
            'action' => 'required|in:check_in,cancel,checkout'
        ]);

        $restaurant = $request->user()->restaurant;
        $reservation = DB::table('reservations')->where('id', $id)->where('restaurant_id', $restaurant->id)->first();

        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Reservasi tidak valid.'], 404);
        }

        // 2. Tambahkan logika status baru
        $newDbStatus = 'pending';
        if ($request->action == 'check_in') $newDbStatus = 'dine_in';
        if ($request->action == 'cancel') $newDbStatus = 'cancelled';
        if ($request->action == 'checkout') $newDbStatus = 'completed'; // Selesai makan

        DB::table('reservations')->where('id', $id)->update([
            'status' => $newDbStatus,
            'updated_at' => Carbon::now()
        ]);

        if ($newDbStatus == 'dine_in' && $reservation->table_id) {
            DB::table('tables')->where('id', $reservation->table_id)->update(['status' => 'occupied']);
        }
        
        // JIKA BATAL ATAU CHECKOUT, MEJA OTOMATIS KEMBALI TERSEDIA
        if (($newDbStatus == 'cancelled' || $newDbStatus == 'completed') && $reservation->table_id) {
            DB::table('tables')->where('id', $reservation->table_id)->update(['status' => 'available']);
        }    

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.'], 200);
    }

    public function show($id)
    {
        // 1. Ambil data reservasi utama beserta nama mejanya
        $reservation = DB::table('reservations')
            ->leftJoin('tables', 'reservations.table_id', '=', 'tables.id')
            ->where('reservations.id', $id)
            ->select('reservations.*', 'tables.name as table_name')
            ->first();

        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        // 2. Ambil data menu asli dari database (tabel reservation_items)
        $items = DB::table('reservation_items')
            ->where('reservation_id', $id)
            ->get();

        // 3. Format data menu agar sesuai dengan penamaan variabel di Frontend Next.js
        $menus = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->menu_name, 
                'qty' => $item->quantity,   
                'notes' => null,
                'is_served' => (bool) $item->is_served           
            ];
        });

        // 4. Kirim balasan ke Frontend
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $reservation->id,
                'name' => $reservation->customer_name,
                'table' => $reservation->table_name ?? '-',
                'menus' => $menus, 
                'general_notes' => $reservation->notes 
            ]
        ]);
    }

    // Fungsi untuk menyimpan status menu yang sudah ada di halaman detail reservasi (checkbox sudah ada)
    public function serveMenus(Request $request, $id)
    {
        $request->validate([
            'menu_ids' => 'array' // Menerima array ID menu yang dicentang
        ]);

        // 1. Reset semua menu di reservasi ini menjadi 'belum disajikan' (false)
        DB::table('reservation_items')->where('reservation_id', $id)->update(['is_served' => false]);

        // 2. Jika ada menu yang dicentang, update statusnya menjadi true
        if (!empty($request->menu_ids)) {
            DB::table('reservation_items')
                ->where('reservation_id', $id)
                ->whereIn('id', $request->menu_ids)
                ->update(['is_served' => true]);
        }

        return response()->json(['success' => true, 'message' => 'Status pesanan berhasil disimpan.']);
    }
}