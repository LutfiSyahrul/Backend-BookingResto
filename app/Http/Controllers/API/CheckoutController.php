<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Reservation;
use App\Models\ReservationItem;
use App\Models\Table;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // 1. FUNGSI UNTUK MENYIMPAN PESANAN BARU
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id'    => 'required|exists:restaurants,id',
            'table_id'         => 'required|exists:tables,id',
            'customer_name'    => 'required|string',
            'customer_phone'   => 'required|string',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'guests'           => 'required|integer',
            'subtotal'         => 'required|numeric',
            'tax'              => 'required|numeric',
            'service_charge'   => 'required|numeric',
            'total_price'      => 'required|numeric',
            'items'            => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $reservation = Reservation::create([
                'user_id'          => $request->user()->id,
                'restaurant_id'    => $request->restaurant_id,
                'table_id'         => $request->table_id,
                'customer_name'    => $request->customer_name,
                'customer_email'   => $request->customer_email,
                'customer_phone'   => $request->customer_phone,
                'reservation_date' => $request->reservation_date,
                'reservation_time' => $request->reservation_time,
                'guests'           => $request->guests,
                'notes'            => $request->notes,
                'subtotal'         => $request->subtotal,
                'tax'              => $request->tax,
                'service_charge'   => $request->service_charge,
                'total_price'      => $request->total_price,
                'status'           => 'pending',
            ]);

            foreach ($request->items as $item) {
                ReservationItem::create([
                    'reservation_id' => $reservation->id,
                    'menu_name'      => $item['name'],
                    'price'          => $item['price'],
                    'quantity'       => $item['quantity'],
                ]);
            }

            //Midtrans akan mengembalikan token untuk setiap transaksi, token ini yang akan digunakan di Next.js untuk memanggil popup pembayaran Midtrans
            $table = Table::find($request->table_id);
            if ($table) {
                $table->update(['status' => 'booked']);
            }

            // ================= INTEGRASI MIDTRANS =================
            // 1. Setup konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
            Config::$is3ds = env('MIDTRANS_IS_3DS', true);

            // 2. Siapkan detail transaksi
            $params = [
                'transaction_details' => [
                    // Kita tambahkan time() biar order_id benar-benar unik setiap transaksi
                    'order_id' => 'RES-' . $reservation->id . '-' . time(), 
                    'gross_amount' => (int) $reservation->total_price, // Harus integer
                ],
                'customer_details' => [
                    'first_name' => $reservation->customer_name,
                    'email'      => $reservation->customer_email ?? 'no-email@bookingresto.com',
                    'phone'      => $reservation->customer_phone,
                ],
            ];

            // 3. Tembak API Midtrans untuk minta Snap Token
            $snapToken = Snap::getSnapToken($params);

            // 4. Update tabel reservations untuk menyimpan token
            $reservation->update(['snap_token' => $snapToken]);
            // ======================================================

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibuat',
                'data'    => [
                    'order_id'   => $reservation->id,
                    // 👇 Token ini yang paling ditunggu oleh Next.js bosku! 👇
                    'snap_token' => $snapToken, 
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error jika perlu: Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    // 2. FUNGSI UNTUK MENAMPILKAN 1 TIKET (Memperbaiki error 500 & Melengkapi Data)
    public function show($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        $restaurant = \App\Models\Restaurant::find($reservation->restaurant_id);
        $restaurantName = $restaurant ? $restaurant->name : 'Restoran Terpilih';

        // TAMBAHAN BARU 1: Ambil data meja dari database 
        $table = \App\Models\Table::find($reservation->table_id);
        $tableName = $table ? $table->name : 'Dicarikan di lokasi';

        //TAMBAHAN BARU 2: Ambil daftar pesanan makanan 
        $items = \App\Models\ReservationItem::where('reservation_id', $id)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'restaurant_name'  => $restaurantName,
                'customer_name'    => $reservation->customer_name,
                'customer_phone'   => $reservation->customer_phone,
                'table_name'       => $tableName,
                'items'            => $items, 
                // ==========================================
                'reservation_date' => $reservation->reservation_date,
                'reservation_time' => $reservation->reservation_time,
                'guests'           => $reservation->guests,
                'subtotal'         => $reservation->subtotal,
                'tax'              => $reservation->tax,
                'service_charge'   => $reservation->service_charge,
                'total_price'      => $reservation->total_price,
                'snap_token'       => $reservation->snap_token,
            ]
        ], 200);
    }

    // 3. FUNGSI UNTUK MENAMPILKAN SEMUA DAFTAR RESERVASI
    public function index(Request $request) 
    {
        $today = date('Y-m-d');        
        // TAMBAHAN PENGAMAN: Ambil data user yang sedang login 
        $user = $request->user(); 

        // LOGIKA PEMBACAAN: Cari reservasi berdasarkan Email ATAU Nomor WA akun
        // UBAH BAGIAN INI: Cari langsung menggunakan user_id
        $reservations = \App\Models\Reservation::where('user_id', $user->id)
                                               ->orderBy('reservation_date', 'desc')
                                               ->get();

        $unpaid = [];   
        $upcoming = [];
        $past = [];

        foreach ($reservations as $res) {
            $restaurant = \App\Models\Restaurant::find($res->restaurant_id);
            $restoName = $restaurant ? $restaurant->name : 'Restoran Terpilih';
            $image = $restaurant && $restaurant->image_url ? $restaurant->image_url : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=200';

            $item = [
                'id' => $res->id,
                'restoName' => $restoName,
                'image' => $image,
                'date' => $res->reservation_date,
                'time' => $res->reservation_time,
                'guests' => $res->guests,
                'status' => $res->status,
                'snap_token' => $res->snap_token, // <--- WAJIB DIKIRIM agar tombol Midtrans menyala!
            ];

            // LOGIKA PEMILAHAN 3 PASUKAN (Berdasarkan Status & Tanggal)
            if ($res->status === 'pending') {
                // 1. Jika belum bayar, masuk ke Belum Bayar
                $unpaid[] = $item;
            } elseif (in_array($res->status, ['completed', 'cancelled'])) {
                // 2. Jika Admin sudah menekan Selesai ATAU Dibatalkan, LANGSUNG masuk Riwayat (Past)
                $past[] = $item;
            } elseif ($res->reservation_date >= $today) {
                // 3. Jika status lunas (booked/dine_in) DAN tanggal belum lewat, masuk Mendatang
                $upcoming[] = $item;
            } else {
            // 4. Jika status lunas (booked) TAPI tanggal sudah lewat (Admin lupa update), masuk Riwayat otomatis
                $past[] = $item;
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'unpaid'   => $unpaid,   
                'upcoming' => $upcoming,
                'past'     => $past
            ]
        ], 200);
    }

    // 4. FUNGSI UNTUK MENERIMA LAPORAN (WEBHOOK) DARI MIDTRANS (CCTV DIMATIKAN)
    public function callback(Request $request)
    {
        $payload = $request->all();
        
        // CCTV DIMATIKAN - Baris Log::info dihapus agar data tidak "bocor" ke log lagi

        $orderId = $payload['order_id'];
        $transactionStatus = $payload['transaction_status'];
        $paymentType = $payload['payment_type'] ?? 'Midtrans';

        $parts = explode('-', $orderId);
        
        if (count($parts) < 2) {
            return response()->json(['message' => 'Format ID salah'], 200);
        }
        
        $reservationId = $parts[1]; 
        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 200);
        }

        // UPDATE STATUS & METODE PEMBAYARAN
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $reservation->status = 'success';
            $reservation->payment_method = ucwords(str_replace('_', ' ', $paymentType)); 
            
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $reservation->status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $reservation->status = 'pending';
        }

        $reservation->save();

        return response()->json(['message' => 'Callback sukses diproses!']);
    }
}