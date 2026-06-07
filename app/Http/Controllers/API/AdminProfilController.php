<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant; 
use App\Models\RestaurantGallery;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AdminProfilController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        
        $restaurant = Restaurant::with('galleries')->where('user_id', $user->id)->first();

        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Restoran tidak ditemukan untuk akun ini.'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil restoran berhasil ditarik.',
            'data' => $restaurant
        ], 200);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $restaurant = Restaurant::where('user_id', $user->id)->first();

        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Restoran tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'category'      => 'nullable|string|in:Restorant,Cafe & Coffee Shop,Seafood,Vegetarian',
            'price_range'   => 'nullable|string|max:255',
            'address'       => 'nullable|string',
            'description'   => 'nullable|string',
            'open_time'     => 'nullable|date_format:H:i', 
            'close_time'    => 'nullable|date_format:H:i', 
            'time_interval' => 'nullable|integer',
            'status'        => 'required|in:open,closed',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $restaurant->name = $request->name;
        $restaurant->category = $request->category;
        $restaurant->price_range = $request->price_range;
        $restaurant->address = $request->address;
        $restaurant->description = $request->description;
        $restaurant->open_time = $request->open_time;
        $restaurant->close_time = $request->close_time;
        $restaurant->time_interval = $request->time_interval;
        $restaurant->status = $request->status;

        if ($request->hasFile('image')) {
            if ($restaurant->image) {
                Storage::disk('public')->delete($restaurant->image);
            }
            $imagePath = $request->file('image')->store('restaurants/covers', 'public');
            $restaurant->image = $imagePath;
        }
        
        $restaurant->save();

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galleryPath = $file->store('restaurants/galleries', 'public');
                
                RestaurantGallery::create([
                    'restaurant_id' => $restaurant->id,
                    'image_url' => $galleryPath
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil dan foto restoran berhasil diperbarui.',
            'data' => $restaurant
        ], 200);
    }

    // Fungsi untuk menghapus foto galeri restoran
    public function deleteGallery(Request $request, $id)
    {
        $user = $request->user();
        $restaurant = Restaurant::where('user_id', $user->id)->first();

        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Restoran tidak ditemukan.'], 404);
        }

        // Cari foto galeri yang mau dihapus, pastikan itu milik restoran ini
        $gallery = RestaurantGallery::where('id', $id)->where('restaurant_id', $restaurant->id)->first();

        if (!$gallery) {
            return response()->json(['success' => false, 'message' => 'Foto tidak ditemukan.'], 404);
        }

        // Hapus file fisik dari storage
        if ($gallery->image_url) {
            Storage::disk('public')->delete($gallery->image_url);
        }

        // Hapus dari database
        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto galeri berhasil dihapus.'
        ], 200);
    }
}