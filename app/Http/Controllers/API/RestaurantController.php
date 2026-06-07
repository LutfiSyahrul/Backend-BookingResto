<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurant::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('price') && $request->price != '') {
            $query->where('price_range', $request->price);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $restaurants = $query->paginate(6);

        // MAPPING: Kita ubah bentuk datanya agar sesuai dengan selera Next.js
        $formattedData = $restaurants->getCollection()->map(function ($resto) {
            return [
                'id'            => $resto->id,
                'name'          => $resto->name,
                'category'      => $resto->category,
                'price_range'   => $resto->price_range,
                'rating'        => $resto->rating,
                'reviews_count' => $resto->reviews_count,
                'location'      => $resto->address, // Biarkan ini kalau ada halaman lain yang butuh
                'address'       => $resto->address, // 👈TAMBAHAN 1: Untuk beranda Next.js bosku
                'status'        => $resto->status, // Mengambil dari kolom address
                'image_url'     => $resto->image,   // Mengambil dari kolom image
                'slug'          => $resto->slug,
            ];
        });

        // Ganti isi collection bawaan dengan yang sudah diformat
        $restaurants->setCollection($formattedData);

        return response()->json([
            'success' => true,
            'message' => 'Data Restoran Berhasil Diambil',
            'data'    => $restaurants
        ], 200);
    }

    // Fungsi untuk detail restoran
    public function show($id)
    {
        // TAMBAHKAN 'galleries' KE DALAM ARRAY WITH
        $restaurant = Restaurant::with(['menus', 'tables', 'galleries'])->find($id);

        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Data Restoran Tidak Ditemukan'], 404);
        }

        
        $formattedData = [
            'id'            => $restaurant->id,
            'name'          => $restaurant->name,
            'category'      => $restaurant->category,
            'price_range'   => $restaurant->price_range,
            'rating'        => $restaurant->rating,
            'reviews_count' => $restaurant->reviews_count,
            'location'      => $restaurant->address, 
            'address'       => $restaurant->address, 
            'status'        => $restaurant->status,
            'image_url'     => $restaurant->image,  
            'description'   => $restaurant->description,
            'open_time'     => $restaurant->open_time,     
            'close_time'    => $restaurant->close_time,    
            'time_interval' => $restaurant->time_interval,
            'menus'         => $restaurant->menus,
            'tables'        => $restaurant->tables,
            'galleries'     => $restaurant->galleries 
        ];

        return response()->json(['success' => true, 'message' => 'Detail Restoran Berhasil Diambil', 'data' => $formattedData], 200);
    }
}