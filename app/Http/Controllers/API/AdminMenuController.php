<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminMenuController extends Controller
{
    public function index(Request $request)
    {
        $restaurant = $request->user()->restaurant;

        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Restoran tidak ditemukan.'], 404);
        }

        $query = DB::table('menus')->where('restaurant_id', $restaurant->id);

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_menu', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != 'Semua Kategori') {
            $query->where('kategori', $request->category);
        }

        $menus = $query->orderBy('created_at', 'desc')->get();

        $formattedMenus = $menus->map(function ($menu) {
            // Pastikan URL gambar bisa dibaca penuh oleh Frontend
            $imageUrl = $menu->gambar_url;
            if ($imageUrl && !str_starts_with($imageUrl, 'http') && !str_starts_with($imageUrl, '/')) {
                $imageUrl = '/storage/' . $imageUrl;
            } else if ($imageUrl && str_starts_with($imageUrl, 'menu/')) {
                 // Menangani data lama bos (seperti 'menu/paket-ayam.jpg')
                 $imageUrl = '/' . $imageUrl;
            }

            return [
                'id' => $menu->id,
                'name' => $menu->nama_menu,
                'desc' => $menu->deskripsi ?? '',
                'category' => $menu->kategori,
                'price' => (int) $menu->harga,
                'isAvailable' => (bool) $menu->is_available,
                'image' => $imageUrl ?? null 
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedMenus
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'category' => 'required|string',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi foto maksimal 2MB
        ]);

        $restaurant = $request->user()->restaurant;
        $imagePath = null;

        // Proses Simpan Foto
        if ($request->hasFile('image')) {
            // Menyimpan ke folder 'storage/app/public/menu_images'
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $imagePath = '/storage/' . $imagePath; // Tambahkan awalan /storage/ untuk database
        }

        $menuId = DB::table('menus')->insertGetId([
            'restaurant_id' => $restaurant->id,
            'nama_menu' => $request->name,
            'deskripsi' => $request->desc,
            'kategori' => $request->category,
            'harga' => $request->price,
            'is_available' => true,
            'gambar_url' => $imagePath, 
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Menu berhasil disimpan.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'category' => 'required|string',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $restaurant = $request->user()->restaurant;
        $menu = DB::table('menus')->where('id', $id)->where('restaurant_id', $restaurant->id)->first();
        
        if (!$menu) {
            return response()->json(['success' => false, 'message' => 'Menu tidak ditemukan.'], 404);
        }

        $updateData = [
            'nama_menu' => $request->name,
            'deskripsi' => $request->desc,
            'kategori' => $request->category,
            'harga' => $request->price,
            'updated_at' => now()
        ];

        // Jika Admin mengunggah foto baru saat di-edit
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $updateData['gambar_url'] = '/storage/' . $imagePath;
        }

        DB::table('menus')->where('id', $id)->update($updateData);

        return response()->json(['success' => true, 'message' => 'Informasi menu berhasil diperbarui.']);
    }

    public function toggleAvailable(Request $request, $id)
    {
        $restaurant = $request->user()->restaurant;
        $menu = DB::table('menus')->where('id', $id)->where('restaurant_id', $restaurant->id)->first();
        if (!$menu) return response()->json(['success' => false, 'message' => 'Menu tidak ditemukan.'], 404);

        DB::table('menus')->where('id', $id)->update(['is_available' => !$menu->is_available, 'updated_at' => now()]);
        return response()->json(['success' => true, 'message' => 'Status diperbarui.']);
    }

    public function destroy(Request $request, $id)
    {
        $restaurant = $request->user()->restaurant;
        DB::table('menus')->where('id', $id)->where('restaurant_id', $restaurant->id)->delete();
        return response()->json(['success' => true, 'message' => 'Menu dihapus.']);
    }
}