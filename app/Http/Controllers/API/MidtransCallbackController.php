<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log; 

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        try {
            $serverKey = env('MIDTRANS_SERVER_KEY');
            
            // Verifikasi keaslian notifikasi dari Midtrans
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            if ($hashed == $request->signature_key) {
                // Jika statusnya lunas (settlement / capture)
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    
                    // Pisahkan ID
                    $idArr = explode('-', $request->order_id);
                    
                    // LOGIKA ANTI-CRASH: Cek apakah format ID benar-benar memiliki tanda '-'
                    if (count($idArr) >= 2) {
                        $databaseId = $idArr[1]; // Ambil ID dari format RES-24-WAKTU
                    } else {
                        $databaseId = $request->order_id; // Jika format lama, langsung gunakan ID-nya
                    }

                    // Cari data reservasi lalu ubah statusnya jadi 'booked'
                    $reservation = Reservation::find($databaseId);
                    if ($reservation) {
                        $reservation->update(['status' => 'booked']);
                    }
                }
            }

            // WAJIB KEMBALIKAN 200 OK agar Midtrans berhenti nge-spam Ngrok bosku!
            return response()->json(['message' => 'Callback diproses dengan aman'], 200);

        } catch (\Exception $e) {
            // Jika ada error lain, catat ke file log Laravel, jangan buat server crash
            Log::error('Error Webhook Midtrans: ' . $e->getMessage());
            
            // Tetap kembalikan 200 OK ke Midtrans sebagai bentuk pertahanan
            return response()->json(['message' => 'Terjadi kesalahan sistem, tapi kami tangani'], 200);
        }
    }
}