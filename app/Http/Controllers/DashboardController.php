<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Statistik untuk dashboard - TAMBAHKAN FILTER USER_ID
        $totalMenu = Menu::where('user_id', $userId)->count();
        $menuTersedia = Menu::where('user_id', $userId)->where('tersedia', true)->count();
        $pesananHariIni = Order::where('user_id', $userId)->today()->count();
        $totalPemasukanHariIni = Order::where('user_id', $userId)->today()->where('status', 'selesai')->sum('total_harga');
        $totalPemasukanBulanIni = Order::where('user_id', $userId)->thisMonth()->where('status', 'selesai')->sum('total_harga');
        
        // Pesanan terbaru - TAMBAHKAN FILTER USER_ID
        $pesananTerbaru = Order::where('user_id', $userId)
            ->with('orderItems.menu')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Menu yang hampir habis (stok < 10) - TAMBAHKAN FILTER USER_ID
        $menuHampirHabis = Menu::where('user_id', $userId)
            ->where('stok', '<', 10)
            ->where('tersedia', true)
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalMenu',
            'menuTersedia',
            'pesananHariIni',
            'totalPemasukanHariIni',
            'totalPemasukanBulanIni',
            'pesananTerbaru',
            'menuHampirHabis'
        ));
    }
}