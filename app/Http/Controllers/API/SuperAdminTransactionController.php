<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class SuperAdminTransactionController extends Controller
{
   public function index(Request $request)
    {
        $query = Reservation::with('restaurant')->orderBy('created_at', 'desc');

        // 1. FILTER PENCARIAN (Search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // 2. FILTER STATUS (Dropdown)
        if ($request->has('status') && $request->status != 'Semua Status' && $request->status != '') {
            $statusFilter = $request->status;
            if ($statusFilter == 'Berhasil') {
                $query->whereIn('status', ['success', 'berhasil', 'dine_in']);
            } elseif ($statusFilter == 'Gagal') {
                $query->whereIn('status', ['failed', 'gagal']);
            } elseif ($statusFilter == 'Pending') {
                $query->whereIn('status', ['pending', 'booked']);
            }
        }

        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }


        // 3. LOGIKA EXPORT vs PAGINATION YANG BENAR
        $isExport = $request->has('export') && $request->export == 'true';
        
        if ($isExport) {
            $rawTransactions = $query->get(); 
            $itemsToTransform = $rawTransactions; // Langsung pakai collection
        } else {
            $rawTransactions = $query->paginate(10); 
            $itemsToTransform = $rawTransactions->items(); // Ambil array items-nya saja
        }

        // 4. Transformasi Data
        $transactions = collect($itemsToTransform)->map(function ($trx) {
            $displayStatus = 'Pending'; 
            if (in_array($trx->status, ['success', 'berhasil', 'dine_in'])) $displayStatus = 'Berhasil';
            if (in_array($trx->status, ['failed', 'gagal'])) $displayStatus = 'Gagal';
            if (in_array($trx->status, ['pending', 'booked'])) $displayStatus = 'Pending';

            return [
                'id' => str_pad($trx->id, 5, '0', STR_PAD_LEFT), 
                'waktu' => \Carbon\Carbon::parse($trx->created_at)->translatedFormat('d M Y, H:i'),
                'restoran' => $trx->restaurant ? $trx->restaurant->name : 'Restoran Tidak Diketahui',
                'customer' => $trx->customer_name,
                'jumlah' => $trx->total_price,
                'metode' => $trx->payment_method ?? 'Midtrans / Gateway', 
                'status' => $displayStatus,
            ];
        });

        // 5. SUMMARY 
        $today = \Carbon\Carbon::today();
        $summary = [
            'total_hari_ini' => Reservation::whereDate('created_at', $today)->count(),
            'pendapatan_hari_ini' => Reservation::whereDate('created_at', $today)
                                        ->whereIn('status', ['success', 'berhasil', 'dine_in'])
                                        ->sum('total_price'),
            'transaksi_berhasil' => Reservation::whereIn('status', ['success', 'berhasil', 'dine_in'])->count(),
            'pending_gagal' => Reservation::whereIn('status', ['pending', 'failed', 'gagal', 'booked'])->count(),
        ];

        return response()->json([
            'success' => true,
            'summary' => $summary,
            // Jika export, langsung kembalikan array transaksi. Jika pagination, kembalikan objek paginate.
            'data' => $isExport ? $transactions : $rawTransactions->setCollection($transactions)
        ], 200);
    }

    public function show($id)
    {
        // Hilangkan teks 'TRX-' jika ada, agar menyisakan ID angka murninya saja
        $cleanId = ltrim(str_replace('TRX-', '', $id), '0');

        // Ambil data reservasi beserta relasi restorannya
        $reservation = Reservation::with('restaurant')->find($cleanId);

        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Ambil daftar makanan yang dipesan dari tabel reservation_items
        $items = \App\Models\ReservationItem::where('reservation_id', $cleanId)->get();

        // Format ulang status agar cantik di UI SweetAlert
        $displayStatus = 'Pending';
        if (in_array($reservation->status, ['success', 'berhasil', 'dine_in'])) $displayStatus = 'Berhasil';
        if (in_array($reservation->status, ['failed', 'gagal'])) $displayStatus = 'Gagal';

        return response()->json([
            'success' => true,
            'data' => [
                'id' => str_pad($reservation->id, 5, '0', STR_PAD_LEFT),
                'customer_name' => $reservation->customer_name,
                'customer_phone' => $reservation->customer_phone,
                'customer_email' => $reservation->customer_email ?? '-',
                'restaurant_name' => $reservation->restaurant ? $reservation->restaurant->name : 'Restoran Terpilih',
                'reservation_date' => \Carbon\Carbon::parse($reservation->reservation_date)->translatedFormat('d F Y'),
                'reservation_time' => $reservation->reservation_time,
                'guests' => $reservation->guests,
                'notes' => $reservation->notes ?? '-',
                'subtotal' => $reservation->subtotal,
                'tax' => $reservation->tax,
                'service_charge' => $reservation->service_charge,
                'total_price' => $reservation->total_price,
                'payment_method' => $reservation->payment_method ?? 'Midtrans / Gateway',
                'status' => $displayStatus,
                'items' => $items
            ]
        ], 200);
    }
}