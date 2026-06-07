<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Fungsi untuk Login
    public function login(Request $request)
    {
        // 1. Validasi inputan dari Next.js
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Cek apakah email dan password cocok di database
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah !'
            ], 401);
        }

        // 3. Jika cocok, ambil data usernya 
        // (GANTI firstOrFail() menjadi first() atau cukup pakai Auth::user() yang lebih elegan)
        $user = Auth::user(); 

       // =======================================================
        // [SATPAM MAINTENANCE MODE]
        // Ambil nilai is_maintenance langsung dari tabel settings
        $isMaintenance = \Illuminate\Support\Facades\DB::table('settings')->value('is_maintenance') == 1; 

        // Jika mode perbaikan AKTIF (nilai 1), dan yang login BUKAN Super Admin, tendang keluar!
        if ($isMaintenance && $user->role !== 'superadmin') {
            return response()->json([
                'success' => false,
                'message' => 'Sistem sedang dalam perbaikan. Harap kembali nanti.'
            ], 403);
        }
        // =======================================================

        // [TAMBAHAN 1]: Keamanan ekstra, blokir kalau akunnya kena Suspend
        if ($user->status === 'suspend') {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda sedang ditangguhkan. Silakan hubungi admin.'
            ], 403);
        }

        // [TAMBAHAN 2]: Update jam login terakhir ke waktu sekarang
        $user->update(['last_login_at' => now()]);

        // 4. Buatkan "Kunci Masuk" (Token) menggunakan Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Kirim balasan ke Next.js
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }

    // Fungsi untuk Logout
    public function logout(Request $request)
    {
        // Hapus kunci (token) yang sedang dipakai
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil!'
        ], 200);
    }

    // Fungsi untuk Register (Daftar Akun Baru)
    public function register(Request $request)
    {   
        // =======================================================
        // [SATPAM MAINTENANCE MODE] Cegah pendaftaran saat perbaikan
        $isMaintenance = \Illuminate\Support\Facades\DB::table('settings')->value('is_maintenance') == 1; 

        if ($isMaintenance) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran ditutup sementara. Sistem sedang dalam perbaikan.'
            ], 403);
        }

        // 1. Validasi inputan dari form Next.js (Dua password akan dicocokkan otomatis oleh 'confirmed')
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Simpan ke database dengan ROLE OTOMATIS
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password), // Password diacak demi keamanan
            'role' => 'customer', // OTOMATIS JADI CUSTOMER!
        ]);

        // 3. Buatkan token agar setelah daftar bisa langsung masuk (Auto-Login)
        $token = $user->createToken('auth_token')->plainTextToken;

        // 4. Kirim balasan ke Next.js
        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil!',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }
    public function updateAvatar(Request $request)
    {   
        // Debugging: Cek apakah file benar-benar sampai di Laravel
        if (!$request->hasFile('avatar')) {
         return response()->json(['message' => 'File avatar tidak ditemukan'], 422);
    }
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = $request->user();

        // Hapus avatar lama jika ada (optional)
        if ($user->avatar_url) {
        $oldPath = str_replace('/storage/', '', $user->avatar_url);
        \Storage::disk('public')->delete($oldPath);
        }

        // Simpan avatar baru
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar_url = '/storage/' . $path;
        $user->save();

        return response()->json(['success' => true, 'avatar_url' => $user->avatar_url]);
    }

}