<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $query = Menu::where('user_id', $userId);
        
        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        // Filter berdasarkan status tersedia
        if ($request->filled('status')) {
            $tersedia = $request->status === 'tersedia';
            $query->where('tersedia', $tersedia);
        }
        
        // Filter berdasarkan stok rendah
        if ($request->filled('stok_rendah')) {
            $query->where('stok', '<', 10);
        }
        
        // Search berdasarkan nama
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        
        $menus = $query->orderBy('kategori')->orderBy('nama')->paginate(12);
        
        $kategoris = ['Nasi', 'Gorengan', 'Minuman', 'Cemilan', 'Lainnya'];
        
        // Statistik untuk dashboard mini - TAMBAHKAN FILTER USER_ID
        $totalMenu = Menu::where('user_id', $userId)->count();
        $menuTersedia = Menu::where('user_id', $userId)->where('tersedia', true)->count();
        $menuStokRendah = Menu::where('user_id', $userId)->where('stok', '<', 10)->where('tersedia', true)->count();
        
        return view('menus.index', compact(
            'menus', 
            'kategoris', 
            'totalMenu', 
            'menuTersedia', 
            'menuStokRendah'
        ));
    }

    public function create()
    {
        $kategoris = ['Nasi', 'Gorengan', 'Minuman', 'Cemilan', 'Lainnya'];
        return view('menus.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:menus,nama',
            'harga' => 'required|numeric|min:100|max:999999',
            'kategori' => 'required|in:Nasi,Gorengan,Minuman,Cemilan,Lainnya',
            'stok' => 'required|integer|min:0|max:9999',
            'deskripsi' => 'nullable|string|max:1000',
            'tersedia' => 'boolean'
        ], [
            'nama.required' => 'Nama menu wajib diisi',
            'nama.unique' => 'Nama menu sudah ada, gunakan nama lain',
            'harga.required' => 'Harga menu wajib diisi',
            'harga.min' => 'Harga minimal Rp 100',
            'kategori.required' => 'Kategori menu wajib dipilih',
            'stok.required' => 'Stok menu wajib diisi',
            'stok.min' => 'Stok tidak boleh negatif'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        
        // Auto set tersedia false jika stok 0
        if ($data['stok'] == 0) {
            $data['tersedia'] = false;
        }

        Menu::create($data);

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function show(Menu $menu)
    {
        // TAMBAHKAN AUTHORIZATION CHECK
        if ($menu->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        $menu->load('orderItems.order');
        
        // Statistik menu
        $totalTerjual = $menu->orderItems()
            ->whereHas('order', function($query) {
                $query->where('status', 'selesai');
            })
            ->sum('jumlah');
            
        $totalPendapatan = $menu->orderItems()
            ->whereHas('order', function($query) {
                $query->where('status', 'selesai');
            })
            ->sum('subtotal');
        
        return view('menus.show', compact('menu', 'totalTerjual', 'totalPendapatan'));
    }

    public function edit(Menu $menu)
    {
        // TAMBAHKAN AUTHORIZATION CHECK
        if ($menu->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        $kategoris = ['Nasi', 'Gorengan', 'Minuman', 'Cemilan', 'Lainnya'];
        return view('menus.edit', compact('menu', 'kategoris'));
    }

    public function update(Request $request, Menu $menu)
    {
        // TAMBAHKAN AUTHORIZATION CHECK
        if ($menu->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menus')->ignore($menu->id)
            ],
            'harga' => 'required|numeric|min:100|max:999999',
            'kategori' => 'required|in:Nasi,Gorengan,Minuman,Cemilan,Lainnya',
            'stok' => 'required|integer|min:0|max:9999',
            'deskripsi' => 'nullable|string|max:1000',
            'tersedia' => 'boolean'
        ], [
            'nama.required' => 'Nama menu wajib diisi',
            'nama.unique' => 'Nama menu sudah ada, gunakan nama lain',
            'harga.required' => 'Harga menu wajib diisi',
            'harga.min' => 'Harga minimal Rp 100',
            'kategori.required' => 'Kategori menu wajib dipilih',
            'stok.required' => 'Stok menu wajib diisi',
            'stok.min' => 'Stok tidak boleh negatif'
        ]);

        $data = $request->all();

        // Auto set tersedia false jika stok 0
        if ($data['stok'] == 0) {
            $data['tersedia'] = false;
        }
        
        // Auto set tersedia true jika stok > 0 dan sebelumnya false karena stok habis
        if ($data['stok'] > 0 && !$menu->tersedia && $menu->stok == 0) {
            $data['tersedia'] = true;
        }

        $menu->update($data);

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        // TAMBAHKAN AUTHORIZATION CHECK
        if ($menu->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        // Cek apakah menu pernah dipesan
        $totalOrderItems = $menu->orderItems()->count();
        
        if ($totalOrderItems > 0) {
            return redirect()->route('menus.index')
                ->with('error', "Menu tidak dapat dihapus karena sudah pernah dipesan sebanyak {$totalOrderItems} kali!");
        }

        $menuName = $menu->nama;
        $menu->delete();

        return redirect()->route('menus.index')
            ->with('success', "Menu '{$menuName}' berhasil dihapus!");
    }
    
    public function updateStock(Request $request, Menu $menu)
    {
        // TAMBAHKAN AUTHORIZATION CHECK
        if ($menu->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        $request->validate([
            'stok' => 'required|integer|min:0|max:9999',
            'action' => 'required|in:add,set'
        ]);
        
        if ($request->action === 'add') {
            $menu->increment('stok', $request->stok);
            $message = "Stok {$menu->nama} berhasil ditambah {$request->stok}";
        } else {
            $menu->update(['stok' => $request->stok]);
            $message = "Stok {$menu->nama} berhasil diubah menjadi {$request->stok}";
        }
        
        // Auto update status tersedia
        if ($menu->stok > 0 && !$menu->tersedia) {
            $menu->update(['tersedia' => true]);
        } elseif ($menu->stok == 0 && $menu->tersedia) {
            $menu->update(['tersedia' => false]);
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    public function toggleAvailability(Menu $menu)
    {
        // TAMBAHKAN AUTHORIZATION CHECK
        if ($menu->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
        
        $menu->update(['tersedia' => !$menu->tersedia]);
        
        $status = $menu->tersedia ? 'tersedia' : 'tidak tersedia';
        
        return redirect()->back()
            ->with('success', "Menu {$menu->nama} berhasil diubah menjadi {$status}");
    }
}