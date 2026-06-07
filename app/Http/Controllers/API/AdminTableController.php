<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTableController extends Controller
{
    // 1. MENGAMBIL SEMUA DATA (Termasuk Kordinat X, Y, dan Bentuk Meja)
    public function index(Request $request)
    {
        $restaurant = $request->user()->restaurant;

        if (!$restaurant) {
            return response()->json(['success' => false, 'message' => 'Restoran tidak ditemukan.'], 404);
        }

        $tables = DB::table('tables')
            ->where('restaurant_id', $restaurant->id)
            ->get();

        $stats = [
            'tersedia' => $tables->where('status', 'available')->count(),
            'dipesan' => $tables->where('status', 'booked')->count(),
            'terisi' => $tables->where('status', 'occupied')->count(),
        ];

        $formattedTables = $tables->map(function ($table) {
            $statusFront = 'Tersedia';
            if ($table->status === 'occupied') $statusFront = 'Terisi';
            if ($table->status === 'booked') $statusFront = 'Dipesan';

            return [
                'id' => $table->id,
                'name' => $table->name,
                'capacity' => $table->capacity,
                'status' => $statusFront,
                'area' => $table->area ?? 'Lantai 1',
                'shape' => $table->shape ?? 'rectangle',
                'pos_x' => (float) $table->pos_x,
                'pos_y' => (float) $table->pos_y,
                'width' => $table->width ?? 75,
                'height' => $table->height ?? 75,
                'info' => '', 
                'customer' => null, // Placeholder untuk relasi pesanan di masa depan
                'price' => 0,
                'items' => []
            ];
        });

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'data' => $formattedTables
        ], 200);
    }

    // 2. Fungsi STORE (Tambah Meja Baru & Zona)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
            'area' => 'required|string',
            'shape' => 'nullable|string|in:rectangle,circle,zone', 
            'pos_x' => 'required|numeric',
            'pos_y' => 'required|numeric',
        ]);

        $restaurant = $request->user()->restaurant;
        
        $tableId = DB::table('tables')->insertGetId([
            'restaurant_id' => $restaurant->id,
            'name' => $request->name,
            'capacity' => $request->capacity,
            'status' => 'available',
            'area' => $request->area,
            'shape' => $request->shape ?? 'rectangle',
            'pos_x' => $request->pos_x,
            'pos_y' => $request->pos_y,
            'width' => $request->width ?? ($request->shape === 'zone' ? 200 : 75),
            'height' => $request->height ?? ($request->shape === 'zone' ? 150 : 75),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Elemen berhasil ditambahkan.']);
    }
    // 3. MENGUBAH PROPERTI MEJA (Nama, Kapasitas, Status, AREA)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'status' => 'required|string',
            'area' => 'required|string' 
        ]);

        $restaurant = $request->user()->restaurant;

        $dbStatus = 'available';
        if ($request->status == 'Terisi') $dbStatus = 'occupied';
        if ($request->status == 'Dipesan') $dbStatus = 'booked';

        DB::table('tables')->where('id', $id)->where('restaurant_id', $restaurant->id)->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'status' => $dbStatus,
            'area' => $request->area,
            'width' => $request->width ?? 75,   
            'height' => $request->height ?? 75, 
            'updated_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'Properti meja berhasil diperbarui.']);
    }

    // 4. MENGHAPUS MEJA
    public function destroy(Request $request, $id)
    {
        $restaurant = $request->user()->restaurant;

        DB::table('tables')
            ->where('id', $id)
            ->where('restaurant_id', $restaurant->id)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Meja berhasil dihapus.']);
    }

    // 5. MENYIMPAN KORDINAT SECARA MASSAL (Fungsi yang lama tetap dipertahankan)
    public function saveLayout(Request $request)
    {
        $request->validate([
            'tables' => 'required|array',
            'tables.*.id' => 'required|exists:tables,id',
            'tables.*.pos_x' => 'required|numeric',
            'tables.*.pos_y' => 'required|numeric',
        ]);

        $restaurant = $request->user()->restaurant;

        DB::beginTransaction();
        try {
            foreach ($request->tables as $t) {
            DB::table('tables')
                ->where('id', $t['id'])
                ->where('restaurant_id', $restaurant->id)
                ->update([
                    'pos_x' => $t['pos_x'],
                    'pos_y' => $t['pos_y'],
                    'width' => $t['width'] ?? 75,   
                    'height' => $t['height'] ?? 75, 
                    'updated_at' => now()
                ]);
        }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Tata letak denah meja berhasil disimpan.'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan tata letak: ' . $e->getMessage()], 500);
        }
    }
}