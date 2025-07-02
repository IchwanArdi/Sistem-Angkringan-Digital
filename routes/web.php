<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth Routes (untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout route (untuk yang sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (harus login dulu)
Route::middleware('auth')->group(function () {
    
    // Dashboard Route
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Menu Routes
    Route::resource('menus', MenuController::class);
    Route::put('menus/{menu}/stock', [MenuController::class, 'updateStock'])->name('menus.update-stock');
    Route::patch('menus/{menu}/toggle-availability', [MenuController::class, 'toggleAvailability'])->name('menus.toggle-availability');
    
    // Order Routes
    Route::resource('orders', OrderController::class)->except(['edit', 'update']);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Report Routes
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/daily-export', [ReportController::class, 'exportDaily'])->name('reports.export-daily');
    
    // API Routes (untuk AJAX calls)
    Route::get('api/menus/available', function() {
        return response()->json(
            \App\Models\Menu::where('user_id', auth()->id())
                ->where('tersedia', true)
                ->where('stok', '>', 0)
                ->select('id', 'nama', 'harga', 'stok', 'kategori')
                ->orderBy('kategori')
                ->orderBy('nama')
                ->get()
        );
    })->name('api.menus.available');
    
    Route::get('api/orders/today', function() {
        return response()->json([
            'count' => \App\Models\Order::whereHas('orderItems.menu', function($query) {
                $query->where('user_id', auth()->id());
            })->whereDate('created_at', today())->count(),
            'revenue' => \App\Models\Order::whereHas('orderItems.menu', function($query) {
                $query->where('user_id', auth()->id());
            })->whereDate('created_at', today())->where('status', 'selesai')->sum('total_harga'),
            'pending' => \App\Models\Order::whereHas('orderItems.menu', function($query) {
                $query->where('user_id', auth()->id());
            })->whereDate('created_at', today())->where('status', 'pending')->count()
        ]);
    })->name('api.orders.today');
    
    // Route untuk mendapatkan statistik cepat
    Route::get('api/dashboard/stats', function() {
        return response()->json([
            'total_menu' => \App\Models\Menu::where('user_id', auth()->id())->count(),
            'menu_tersedia' => \App\Models\Menu::where('user_id', auth()->id())->where('tersedia', true)->count(),
            'pesanan_hari_ini' => \App\Models\Order::whereHas('orderItems.menu', function($query) {
                $query->where('user_id', auth()->id());
            })->whereDate('created_at', today())->count(),
            'pendapatan_hari_ini' => \App\Models\Order::whereHas('orderItems.menu', function($query) {
                $query->where('user_id', auth()->id());
            })->whereDate('created_at', today())->where('status', 'selesai')->sum('total_harga'),
            'menu_stok_rendah' => \App\Models\Menu::where('user_id', auth()->id())->where('stok', '<', 10)->where('tersedia', true)->count()
        ]);
    })->name('api.dashboard.stats');
    
});

// Redirect root ke dashboard jika sudah login, atau ke login jika belum
Route::get('/home', function () {
    return redirect()->route('dashboard');
});