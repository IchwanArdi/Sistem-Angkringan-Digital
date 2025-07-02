<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('orderItems.menu')->where('user_id', auth()->id());

        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
        
        // Search berdasarkan kode order
        if ($request->filled('search')) {
            $query->where('kode_order', 'like', '%' . $request->search . '%');
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $menus = Menu::where('tersedia', true)
            ->where('stok', '>', 0)
            ->orderBy('kategori')
            ->orderBy('nama')
            ->get();
            
        $kategoris = $menus->groupBy('kategori');
        
        return view('orders.create', compact('menus', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        
        try {
            $totalHarga = 0;
            $orderItems = [];
            
            // Validasi stok dan hitung total
            foreach ($request->items as $item) {
                $menu = Menu::lockForUpdate()->findOrFail($item['menu_id']);
                
                // Validasi menu tersedia
                if (!$menu->tersedia) {
                    throw ValidationException::withMessages([
                        'items' => "Menu {$menu->nama} sedang tidak tersedia!"
                    ]);
                }
                
                // Validasi stok
                if ($menu->stok < $item['jumlah']) {
                    throw ValidationException::withMessages([
                        'items' => "Stok {$menu->nama} tidak mencukupi! Stok tersisa: {$menu->stok}"
                    ]);
                }
                
                $subtotal = $menu->harga * $item['jumlah'];
                $totalHarga += $subtotal;
                
                $orderItems[] = [
                    'menu_id' => $menu->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $menu->harga,
                    'subtotal' => $subtotal,
                    'menu' => $menu
                ];
            }
            
            // Buat order
            $order = Order::create([
                'user_id' => auth()->id(),
                'kode_order' => Order::generateKodeOrder(),
                'total_harga' => $totalHarga,
                'status' => 'pending',
                'catatan' => $request->catatan
            ]);
            
            // Buat order items dan kurangi stok
            foreach ($orderItems as $orderItem) {
                $order->orderItems()->create([
                    'menu_id' => $orderItem['menu_id'],
                    'jumlah' => $orderItem['jumlah'],
                    'harga_satuan' => $orderItem['harga_satuan'],
                    'subtotal' => $orderItem['subtotal']
                ]);
                
                // Kurangi stok menu
                $orderItem['menu']->decrement('stok', $orderItem['jumlah']);
                
                // Set menu tidak tersedia jika stok habis
                if ($orderItem['menu']->stok - $orderItem['jumlah'] <= 0) {
                    $orderItem['menu']->update(['tersedia' => false]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat! Kode Order: ' . $order->kode_order);
                
        } catch (ValidationException $e) {
            DB::rollback();
            throw $e;
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        // TAMBAHKAN AUTHORIZATION CHECK
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        $order->load('orderItems.menu');
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,selesai,dibatalkan'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        DB::beginTransaction();
        
        try {
            // Jika status diubah ke dibatalkan, kembalikan stok
            if ($newStatus === 'dibatalkan' && $oldStatus !== 'dibatalkan') {
                foreach ($order->orderItems as $item) {
                    $menu = $item->menu;
                    $menu->increment('stok', $item->jumlah);
                    
                    // Set menu tersedia jika sebelumnya tidak tersedia
                    if (!$menu->tersedia && $menu->stok > 0) {
                        $menu->update(['tersedia' => true]);
                    }
                }
            }
            
            // Jika status dari dibatalkan ke status lain, kurangi stok lagi
            if ($oldStatus === 'dibatalkan' && $newStatus !== 'dibatalkan') {
                foreach ($order->orderItems as $item) {
                    $menu = $item->menu;
                    
                    // Validasi stok tersedia
                    if ($menu->stok < $item->jumlah) {
                        throw ValidationException::withMessages([
                            'status' => "Tidak dapat mengubah status karena stok {$menu->nama} tidak mencukupi!"
                        ]);
                    }
                    
                    $menu->decrement('stok', $item->jumlah);
                    
                    // Set menu tidak tersedia jika stok habis
                    if ($menu->stok <= 0) {
                        $menu->update(['tersedia' => false]);
                    }
                }
            }

            $order->update(['status' => $newStatus]);
            
            DB::commit();
            
            return redirect()->back()
                ->with('success', 'Status pesanan berhasil diperbarui!');
                
        } catch (ValidationException $e) {
            DB::rollback();
            throw $e;
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function destroy(Order $order)
    {
        // Hanya bisa hapus order yang dibatalkan atau belum diproses
        if (!in_array($order->status, ['pending', 'dibatalkan'])) {
            return redirect()->route('orders.index')
                ->with('error', 'Tidak dapat menghapus pesanan yang sudah selesai!');
        }
        
        DB::beginTransaction();
        
        try {
            // Kembalikan stok jika order masih pending
            if ($order->status === 'pending') {
                foreach ($order->orderItems as $item) {
                    $menu = $item->menu;
                    $menu->increment('stok', $item->jumlah);
                    
                    // Set menu tersedia jika sebelumnya tidak tersedia
                    if (!$menu->tersedia && $menu->stok > 0) {
                        $menu->update(['tersedia' => true]);
                    }
                }
            }
            
            $order->delete();
            
            DB::commit();
            
            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}