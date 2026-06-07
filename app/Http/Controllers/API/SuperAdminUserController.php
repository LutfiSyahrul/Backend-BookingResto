<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // 1. Fitur Pencarian (Berdasarkan nama atau email)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Fitur Filter Peran (Role)
        if ($request->has('role') && $request->role != 'Semua Peran') {
            $query->where('role', $request->role);
        }

        // 3. Fitur Filter Status
        if ($request->has('status') && $request->status != 'Semua Status') {
            // Menyesuaikan teks dropdown frontend dengan isi database
            $dbStatus = $request->status;
            if ($request->status === 'Aktif') $dbStatus = 'active';
            if ($request->status === 'Suspend') $dbStatus = 'suspend';
            
            $query->where('status', $dbStatus);
        }

        // 4. Eksekusi Pagination (Menampilkan 10 user per halaman)
        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $users
        ], 200);
    }

    // Fungsi untuk Toggle Status (Aktif <-> Suspend)
    public function toggleStatus($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        // Opsional: Keamanan agar Super Admin tidak bisa men-suspend dirinya sendiri
        if (auth()->id() === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengubah status akun Anda sendiri'
            ], 403);
        }

        // Ubah status (Jika active/Aktif -> suspend, sebaliknya -> active)
        if ($user->status === 'active' || $user->status === 'Aktif') {
            $user->status = 'suspend';
        } else {
            $user->status = 'active';
        }
        
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Status pengguna berhasil diperbarui',
            'data' => $user
        ], 200);
    }

    // Fungsi Tambah User Baru
    public function store(Request $request)
    {
        // Validasi ketat agar tidak ada email ganda atau password yang terlalu pendek
        // 👇 Hapus user_id dari sini karena ini form buat User, bukan buat Restoran
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'status' => 'required|string'
        ]);

        // Eksekusi pembuatan user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-hash!
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna baru berhasil ditambahkan',
            'data' => $user
        ], 201);
    }

    // Fungsi untuk Hapus Pengguna Permanen
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        // Mencegah admin bunuh diri (menghapus akunnya sendiri yang sedang dipakai)
        if (auth()->id() === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus akun yang sedang Anda gunakan'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dihapus'
        ], 200);
    }

    // Fungsi Detail User
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $user], 200);
    }

    // Fungsi Update Data User
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'status' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        // Sesuaikan status dari frontend ke database
        $user->status = ($request->status === 'Aktif' || $request->status === 'active') ? 'active' : 'suspend';
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Data user berhasil diperbarui',
            'data' => $user
        ], 200);
    }

    // Fungsi mengambil user ber-role adminresto yang BELUM punya restoran
    public function getRestoOwners()
    {
        $owners = User::where('role', 'adminresto')
            ->whereNotIn('id', function($query) {
                // Cari semua user_id yang sudah terpakai di tabel restaurants
                $query->select('user_id')
                      ->from('restaurants')
                      ->whereNotNull('user_id');
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $owners
        ], 200);
    }

}