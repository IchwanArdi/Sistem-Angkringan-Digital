<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        
        // Query orders berdasarkan tanggal - TAMBAHKAN FILTER USER_ID
        $orders = Order::where('user_id', $userId)
            ->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ])->with('orderItems.menu')->get();
        
        // Hitung statistik
        $totalOrders = $orders->count();
        $totalRevenue = $orders->where('status', 'selesai')->sum('total_harga');
        
        // Statistik harian - TAMBAHKAN FILTER USER_ID
        $dailyStats = Order::where('user_id', $userId)
            ->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ])
            ->where('status', 'selesai')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_harga) as daily_revenue')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
        
        // Menu terlaris - TAMBAHKAN FILTER USER_ID
        $topMenus = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->where('orders.user_id', $userId) // TAMBAHKAN INI
            ->whereBetween('orders.created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ])
            ->where('orders.status', 'selesai')
            ->select(
                'menus.nama',
                'menus.kategori',
                DB::raw('SUM(order_items.jumlah) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('menus.id', 'menus.nama', 'menus.kategori')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        // Statistik per kategori - TAMBAHKAN FILTER USER_ID
        $categoryStats = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->where('orders.user_id', $userId) // TAMBAHKAN INI
            ->whereBetween('orders.created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ])
            ->where('orders.status', 'selesai')
            ->select(
                'menus.kategori',
                DB::raw('SUM(order_items.jumlah) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->groupBy('menus.kategori')
            ->orderBy('total_revenue', 'desc')
            ->get();
        
        return view('reports.index', compact(
            'orders',
            'totalOrders',
            'totalRevenue',
            'dailyStats',
            'topMenus',
            'categoryStats',
            'startDate',
            'endDate'
        ));
    }
    
    public function exportDaily(Request $request)
    {
        $userId = auth()->id();
        $date = $request->get('date', now()->format('Y-m-d'));
        
        // TAMBAHKAN FILTER USER_ID
        $orders = Order::where('user_id', $userId)
            ->whereDate('created_at', $date)
            ->with('orderItems.menu')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalRevenue = $orders->where('status', 'selesai')->sum('total_harga');
        $totalOrders = $orders->count();
        
        return response()->json([
            'date' => $date,
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'orders' => $orders
        ]);
    }
}