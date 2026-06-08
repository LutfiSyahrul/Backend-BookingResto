<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RestaurantController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Middleware\RoleMiddleware; 
use App\Http\Controllers\API\AiAssistantController;
use App\Http\Controllers\API\AdminReservationController;

// Pintu masuk untuk Login (Tidak perlu token)
// Route::post('/login', [AuthController::class, 'login']);

// Aturan 'throttle:5,1' -> Maksimal 5 kali request dalam 1 menit
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

// pintu masuk untuk Register (Tidak perlu token)
Route::post('/register', [AuthController::class, 'register']);

// Rute Publik (Bisa diakses siapa saja tanpa login)
Route::get('/restaurants', [RestaurantController::class, 'index']);
Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);

//Customer BACA PAJAK 
Route::get('/settings', [\App\Http\Controllers\API\SettingController::class, 'getSettings']);

// Rute Publik untuk Chatbot AI
Route::post('/chatbot/ask', [AiAssistantController::class, 'chat'])->middleware('throttle:5,1'); // Batasi 5 pertanyaan per menit untuk mencegah penyalahgunaan

// rute untuk callback Midtrans (tidak perlu auth karena Midtrans yang akan akses) 
Route::post('/midtrans/callback', [\App\Http\Controllers\API\MidtransCallbackController::class, 'callback']);

Route::post('/midtrans/callback', [\App\Http\Controllers\API\CheckoutController::class, 'callback']);


// ==========================================
// AREA WAJIB LOGIN (Semua Role)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Pindah ke sini karena cuma user login yang boleh booking & lihat riwayat!
    Route::post('/checkout', [CheckoutController::class, 'store']);
    Route::get('/orders/{id}', [CheckoutController::class, 'show']);
    Route::get('/my-reservations', [CheckoutController::class, 'index']);

    // Rute untuk favorit restoran (hanya untuk user yang login)
    Route::get('/favorites', [\App\Http\Controllers\API\FavoriteController::class, 'index']);
    Route::post('/favorites/{restaurant_id}/toggle', [\App\Http\Controllers\API\FavoriteController::class, 'toggle']);

    // Rute untuk update avatar (hanya untuk user yang login)
    Route::post('/user/update-avatar', [AuthController::class, 'updateAvatar']);

    

});


// ==========================================
// AREA KHUSUS ADMIN RESTO
// ==========================================
Route::middleware(['auth:sanctum', RoleMiddleware::class.':adminresto'])->group(function () {
    
    // API Utama Dashboard Admin Resto
    Route::get('/admin/dashboard', [\App\Http\Controllers\API\AdminDashboardController::class, 'index']);
    

    // API Management Reservasi
    Route::get('/admin/reservations', [\App\Http\Controllers\API\AdminReservationController::class, 'index']);
    Route::post('/admin/reservations/{id}/status', [\App\Http\Controllers\API\AdminReservationController::class, 'updateStatus']);
    Route::get('/admin/reservations/{id}', [\App\Http\Controllers\API\AdminReservationController::class, 'show']);
    Route::post('/admin/reservations/{id}/serve', [AdminReservationController::class, 'serveMenus']);

    // API Management Meja (CRUD & Layout)
    Route::get('/admin/tables', [\App\Http\Controllers\API\AdminTableController::class, 'index']);
    Route::post('/admin/tables', [\App\Http\Controllers\API\AdminTableController::class, 'store']);
    Route::put('/admin/tables/{id}', [\App\Http\Controllers\API\AdminTableController::class, 'update']);
    Route::delete('/admin/tables/{id}', [\App\Http\Controllers\API\AdminTableController::class, 'destroy']);
    Route::post('/admin/tables/layout', [\App\Http\Controllers\API\AdminTableController::class, 'saveLayout']);

    // API Management Menu (CRUD & Toggle Switch)
    Route::get('/admin/menus', [\App\Http\Controllers\API\AdminMenuController::class, 'index']);
    Route::post('/admin/menus', [\App\Http\Controllers\API\AdminMenuController::class, 'store']);
    Route::put('/admin/menus/{id}', [\App\Http\Controllers\API\AdminMenuController::class, 'update']);
    Route::patch('/admin/menus/{id}/toggle', [\App\Http\Controllers\API\AdminMenuController::class, 'toggleAvailable']);
    Route::delete('/admin/menus/{id}', [\App\Http\Controllers\API\AdminMenuController::class, 'destroy']);

    // API Laporan / Dashboard
    Route::get('/admin/laporan', [\App\Http\Controllers\API\AdminLaporanController::class, 'index']);

    // API Profil Admin Resto
    Route::get('/admin/profil', [App\Http\Controllers\API\AdminProfilController::class, 'show']);
    Route::post('/admin/profil/update', [App\Http\Controllers\API\AdminProfilController::class, 'update']);

    // API untuk menghapus foto galeri restoran
    Route::delete('/admin/profil/galeri/{id}', [App\Http\Controllers\API\AdminProfilController::class, 'deleteGallery']);
    
});

// ==========================================
// AREA KHUSUS SUPER ADMIN
// ==========================================
// Gembok ganda: Wajib login role superadmin
Route::middleware(['auth:sanctum', RoleMiddleware::class.':superadmin'])->group(function () {
    
    // API Utama Dashboard Super Admin
    Route::get('/superadmin/dashboard', [\App\Http\Controllers\API\SuperAdminDashboardController::class, 'index']);
    
    // API Management Restoran (Super Admin)
    Route::get('/superadmin/restaurants', [\App\Http\Controllers\API\SuperAdminRestaurantController::class, 'index']);

    // API Detail, Approve, Hapus Restoran (Super Admin)
    Route::get('/superadmin/restaurants/{id}', [\App\Http\Controllers\API\SuperAdminRestaurantController::class, 'show']);
    Route::patch('/superadmin/restaurants/{id}/approve', [\App\Http\Controllers\API\SuperAdminRestaurantController::class, 'approve']);
    Route::delete('/superadmin/restaurants/{id}', [\App\Http\Controllers\API\SuperAdminRestaurantController::class, 'destroy']);
    Route::post('/superadmin/restaurants/{id}', [\App\Http\Controllers\API\SuperAdminRestaurantController::class, 'update']);
    Route::post('/superadmin/restaurants', [\App\Http\Controllers\API\SuperAdminRestaurantController::class, 'store']);

    // API Management User (Super Admin)
    Route::get('/superadmin/users', [\App\Http\Controllers\API\SuperAdminUserController::class, 'index']);
    Route::patch('/superadmin/users/{id}/toggle-status', [\App\Http\Controllers\API\SuperAdminUserController::class, 'toggleStatus']);
    Route::delete('/superadmin/users/{id}', [\App\Http\Controllers\API\SuperAdminUserController::class, 'destroy']);
    Route::get('/superadmin/users/{id}', [\App\Http\Controllers\API\SuperAdminUserController::class, 'show']);
    Route::post('/superadmin/users/{id}', [\App\Http\Controllers\API\SuperAdminUserController::class, 'update']);
    Route::post('/superadmin/users', [\App\Http\Controllers\API\SuperAdminUserController::class, 'store']);
    Route::get('/superadmin/list-owners', [\App\Http\Controllers\API\SuperAdminUserController::class, 'getRestoOwners']);

    Route::get('/superadmin/transactions', [\App\Http\Controllers\API\SuperAdminTransactionController::class, 'index']);
    Route::get('/superadmin/transactions/{id}', [\App\Http\Controllers\API\SuperAdminTransactionController::class, 'show']);

    // API untuk laporan super admin
    Route::get('/superadmin/reports', [\App\Http\Controllers\API\SuperAdminReportController::class, 'getAnalytics']);

    
    // Route::get('/superadmin/settings', [\App\Http\Controllers\API\SettingController::class, 'getSettings']);

    Route::post('/superadmin/settings', [\App\Http\Controllers\API\SettingController::class, 'updateSettings']);

});