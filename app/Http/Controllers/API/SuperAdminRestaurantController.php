<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SuperAdminRestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurant::query();

        // 1. Fitur Pencarian (Berdasarkan nama, lokasi, atau ID)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%"); 
            });
        }

        // 2. Fitur Filter Status 
        if ($request->has('status') && $request->status != 'Semua Status') {
            // Mapping dari bahasa Indonesia (Frontend) ke nilai asli Database
            $dbStatus = $request->status;
            if ($request->status === 'Aktif') $dbStatus = 'open';
            if ($request->status === 'Nonaktif') $dbStatus = 'closed';
            
            $query->where('status', $dbStatus);
        }

        // 3. Fitur Filter Kategori
        if ($request->has('category') && $request->category != 'Semua Kategori') {
            $query->where('category', $request->category);
        }

        // 4. Eksekusi Pagination
        $restaurants = $query->orderBy('created_at', 'desc')->paginate(10);

        // 5. TRANSFORMASI DATA (Menyesuaikan dengan format Frontend Next.js)
        $restaurants->getCollection()->transform(function ($resto) {
            // Mapping status sementara (kalau di DB isinya open/close)
            // Jika di DB sudah pakai Pending/Aktif/Nonaktif, hapus blok if ini
            $displayStatus = $resto->status;
            if ($resto->status == 'open') $displayStatus = 'Aktif';
            if ($resto->status == 'closed') $displayStatus = 'Nonaktif';

            return [
                'id' => $resto->id,
                'nama' => $resto->name,
                // Manipulasi ID jadi kode keren: ID 1 -> #RES-0001
                'kode' => '#RES-' . str_pad($resto->id, 4, '0', STR_PAD_LEFT),
                'lokasi' => $resto->address ? $resto->address : 'Belum ada lokasi',
                'kategori' => $resto->category ? $resto->category : 'Umum',
                'tanggal' => Carbon::parse($resto->created_at)->translatedFormat('d M Y'),
                'status' => $displayStatus,
                // Cek kalau ada gambar di storage, kalau tidak pakai placeholder
                'image' => $resto->image 
                            ? url('storage/' . $resto->image) 
                            : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=100&q=80'
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $restaurants
        ], 200);
    }

    // 1. Fungsi Detail (Untuk ditarik ke halaman Detail & Edit)
    public function show($id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Restoran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $restaurant
        ], 200);
    }

    // 2. Fungsi Approve (Mengubah status menjadi open/Aktif)
    public function approve($id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Restoran tidak ditemukan'
            ], 404);
        }

        // Asumsi status di database bosku menggunakan 'open' untuk Aktif
        $restaurant->status = 'open'; 
        $restaurant->save();

        return response()->json([
            'success' => true,
            'message' => 'Restoran berhasil disetujui'
        ], 200);
    }

    // 3. Fungsi Hapus (Delete permanen)
    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Restoran tidak ditemukan'
            ], 404);
        }

        $restaurant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Restoran berhasil dihapus'
        ], 200);
    }

    // 4. Fungsi Update Data Restoran
    public function update(Request $request, $id)
    {   
        $request->validate([
            'category' => 'nullable|string|in:Restorant,Cafe & Coffee Shop,Seafood,Vegetarian',
        ]);
        
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Restoran tidak ditemukan'
            ], 404);
        }

        // Update data teks
        $restaurant->name = $request->name ?? $restaurant->name;
        $restaurant->category = $request->category ?? $restaurant->category;
        $restaurant->price_range = $request->price_range ?? $restaurant->price_range;
        $restaurant->status = $request->status ?? $restaurant->status;
        $restaurant->address = $request->address ?? $restaurant->address;
        $restaurant->description = $request->description ?? $restaurant->description;
        $restaurant->open_time = $request->open_time ?? $restaurant->open_time;
        $restaurant->close_time = $request->close_time ?? $restaurant->close_time;
        $restaurant->time_interval = $request->time_interval ?? $restaurant->time_interval;

        // Cek kalau ada file gambar baru yang diupload
        if ($request->hasFile('image')) {
            // Upload gambar baru ke folder storage/app/public/restaurants
            $path = $request->file('image')->store('restaurants', 'public');
            $restaurant->image = $path;
        }

        $restaurant->save();

        return response()->json([
            'success' => true,
            'message' => 'Data restoran berhasil diperbarui',
            'data' => $restaurant
        ], 200);
    }

    // 5. Fungsi Tambah Restoran Baru (Create)
    public function store(Request $request)
    {
        // Validasi data yang masuk, pastikan user_id wajib ada dan valid
        // GANTI BAGIAN INI SAJA DI DALAM FUNGSI store
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id', 
            'category' => 'nullable|string|in:Restorant,Cafe & Coffee Shop,Seafood,Vegetarian',
            'status' => 'required|string',
        ]);

        $restaurant = new Restaurant();
        $restaurant->name = $request->name;
        $restaurant->slug = Str::slug($request->name);

        $restaurant->user_id = $request->user_id; // Menyambungkan ke akun Resto Owner
        $restaurant->category = $request->category ?? 'Umum';
        
        // Menyesuaikan status dari frontend ke database
        $dbStatus = 'pending'; // Default kalau tidak ada
        if ($request->status === 'Aktif' || $request->status === 'open') $dbStatus = 'open';
        if ($request->status === 'Nonaktif' || $request->status === 'closed') $dbStatus = 'closed';
        
        $restaurant->status = $dbStatus;

        $restaurant->status = $dbStatus;

        // --- TANGKAP SISA FORM & UPLOAD GAMBAR DARI NEXT.JS ---
        $restaurant->price_range = $request->price_range ?? '$$';
        $restaurant->address = $request->address;
        $restaurant->description = $request->description;
        $restaurant->open_time = $request->open_time ?? '09:00';
        $restaurant->close_time = $request->close_time ?? '22:00';
        $restaurant->time_interval = $request->time_interval ?? 60;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('restaurants', 'public');
            $restaurant->image = $path;
        }
        
        $restaurant->save();

        return response()->json([
            'success' => true,
            'message' => 'Restoran baru berhasil ditambahkan dan dikaitkan dengan pemiliknya!',
            'data' => $restaurant
        ], 201);
    }
}