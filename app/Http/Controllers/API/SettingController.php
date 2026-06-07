<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    // MENGAMBIL DATA PENGATURAN (GET)
    public function getSettings()
    {
        // Ambil baris pertama dari tabel settings
        $settings = Setting::first();
        
        // Jika database masih kosong melompong, otomatis buatkan 1 baris default
        if (!$settings) {
            $settings = Setting::create([]); 
        }

        return response()->json([
            'success' => true,
            'data' => $settings
        ], 200);
    }

    // MENYIMPAN / UPDATE PENGATURAN (POST)
    public function updateSettings(Request $request)
    {
        $settings = Setting::first();

        // Update data berdasarkan input dari form Next.js
        $settings->update([
            'platform_name' => $request->platform_name,
            'contact_email' => $request->contact_email,
            'whatsapp' => $request->whatsapp,
            'tax_rate' => $request->tax_rate,
            'service_rate' => $request->service_rate, 
            'is_maintenance' => $request->is_maintenance
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Konfigurasi sistem berhasil diperbarui.',
            'data' => $settings
        ], 200);
    }

}