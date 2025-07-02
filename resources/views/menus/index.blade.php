@extends('layouts.app')

@section('title', 'Daftar Menu - Sistem Angkringan')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-utensils mr-3 text-primary-600"></i>
                Daftar Menu
            </h1>
            <p class="mt-2 text-gray-600">Kelola menu angkringan Anda dengan mudah</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('menus.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                <i class="fas fa-plus mr-2"></i>
                Tambah Menu
            </a>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-filter mr-2 text-gray-600"></i>
            Filter Menu
        </h3>
        <form method="GET" action="{{ route('menus.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori }}" 
                                {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak_tersedia" {{ request('status') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Menu</label>
                    <input type="text" name="search" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out"
                           placeholder="Nama menu..." value="{{ request('search') }}">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        Filter
                    </button>
                </div>
                
                <div class="flex items-end">
                    <a href="{{ route('menus.index') }}" 
                       class="w-full px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out flex items-center justify-center">
                        <i class="fas fa-refresh mr-2"></i>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Menu Grid -->
@if($menus->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    @foreach($menus as $menu)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-primary-50 to-orange-50 px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $menu->nama }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                        <i class="fas fa-tag mr-1"></i>
                        {{ $menu->kategori }}
                    </span>
                </div>
                <div class="flex items-center">
                    @if($menu->tersedia)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Tersedia
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>
                            Tidak Tersedia
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Card Body -->
        <div class="p-6">
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Harga:</span>
                    <span class="text-lg font-bold text-primary-600">{{ $menu->formatted_harga }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Stok:</span>
                    <span class="text-sm font-semibold {{ $menu->stok < 10 ? 'text-red-600' : 'text-green-600' }}">
                        @if($menu->stok < 10)
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                        @endif
                        {{ $menu->stok }} unit
                    </span>
                </div>
                
                @if($menu->deskripsi)
                <div class="pt-3 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Deskripsi:</span><br>
                        {{ Str::limit($menu->deskripsi, 100) }}
                    </p>
                </div>
                @endif
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-2 mt-6">
                <a href="{{ route('menus.edit', $menu) }}" 
                   class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <form method="POST" action="{{ route('menus.destroy', $menu) }}" 
                      class="flex-1"
                      onsubmit="return confirm('Yakin ingin menghapus menu {{ $menu->nama }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-4">
    {{ $menus->appends(request()->query())->links() }}
</div>

@else
<!-- Empty State -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <div class="max-w-sm mx-auto">
        <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-utensils text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada menu ditemukan</h3>
        <p class="text-gray-500 mb-6">
            @if(request()->hasAny(['kategori', 'status', 'search']))
                Tidak ada menu yang sesuai dengan filter yang Anda pilih.
            @else
                Belum ada menu yang ditambahkan ke sistem.
            @endif
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            @if(request()->hasAny(['kategori', 'status', 'search']))
                <a href="{{ route('menus.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-refresh mr-2"></i>
                    Reset Filter
                </a>
            @endif
            <a href="{{ route('menus.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>
                Tambah Menu Pertama
            </a>
        </div>
    </div>
</div>
@endif

<!-- Stats Summary -->
@if($menus->count() > 0)
<div class="mt-8 bg-gradient-to-r from-primary-50 to-orange-50 rounded-xl p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-chart-pie mr-2 text-primary-600"></i>
        Ringkasan Menu
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <div class="text-2xl font-bold text-blue-600">{{ $menus->total() }}</div>
            <div class="text-sm text-gray-600">Total Menu</div>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <div class="text-2xl font-bold text-green-600">{{ $menus->where('tersedia', true)->count() }}</div>
            <div class="text-sm text-gray-600">Tersedia</div>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <div class="text-2xl font-bold text-red-600">{{ $menus->where('tersedia', false)->count() }}</div>
            <div class="text-sm text-gray-600">Tidak Tersedia</div>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <div class="text-2xl font-bold text-orange-600">{{ $menus->where('stok', '<', 10)->count() }}</div>
            <div class="text-sm text-gray-600">Stok Menipis</div>
        </div>
    </div>
</div>
@endif
@endsection