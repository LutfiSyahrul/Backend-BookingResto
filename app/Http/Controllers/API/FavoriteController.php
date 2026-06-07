<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant; 

class FavoriteController extends Controller
{
    // 1. Menampilkan daftar restoran favorit milik user yang sedang login
    public function index(Request $request)
    {
        // Otomatis mengambil data restoran dari relasi favorit
        $favorites = $request->user()->favoriteRestaurants;
        
        return response()->json([
            'success' => true,
            'message' => 'Daftar Favorit Berhasil Diambil',
            'data' => $favorites
        ], 200);
    }

    // 2. Fungsi sakti Toggle (Simpan jika belum ada, Hapus jika sudah ada)
    public function toggle(Request $request, $restaurant_id)
    {
        $user = $request->user();
        
        $restaurant = Restaurant::find($restaurant_id);
        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Restoran tidak ditemukan'], 404);
        }

        // Fungsi toggle otomatis bawaan Laravel (super praktis!)
        $user->favoriteRestaurants()->toggle($restaurant_id);

        // Cek status saat ini setelah di-toggle untuk balasan ke frontend
        $isFavorited = $user->favoriteRestaurants()->where('restaurant_id', $restaurant_id)->exists();

        return response()->json([
            'success' => true,
            'message' => $isFavorited ? 'Ditambahkan ke Favorit' : 'Dihapus dari Favorit',
            'is_favorited' => $isFavorited
        ], 200);
    }
}