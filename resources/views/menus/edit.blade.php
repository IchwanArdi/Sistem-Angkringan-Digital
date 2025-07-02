@extends('layouts.app')

@section('title', 'Edit Menu - Sistem Angkringan')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-edit mr-3 text-primary-600"></i>
                Edit Menu: {{ $menu->nama }}
            </h1>
            <p class="mt-2 text-gray-600">Perbarui informasi menu angkringan Anda</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('menus.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Menu
            </a>
        </div>
    </div>
</div>

<!-- Form Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="bg-gradient-to-r from-primary-50 to-orange-50 px-6 py-4 border-b border-gray-200 rounded-t-xl">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
            <i class="fas fa-utensils mr-2 text-primary-600"></i>
            Form Edit Menu
        </h2>
        <p class="text-sm text-gray-600 mt-1">Lengkapi form berikut untuk memperbarui menu</p>
    </div>
    
    <div class="p-6">
        <form method="POST" action="{{ route('menus.update', $menu) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Row 1: Nama Menu & Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="nama" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-utensils mr-1 text-gray-500"></i>
                        Nama Menu
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out @error('nama') border-red-500 @enderror" 
                           value="{{ old('nama', $menu->nama) }}" 
                           placeholder="Masukkan nama menu"
                           required>
                    @error('nama')
                        <div class="flex items-center mt-1 text-red-600 text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label for="kategori" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-tag mr-1 text-gray-500"></i>
                        Kategori
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori" 
                            id="kategori" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out @error('kategori') border-red-500 @enderror" 
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori }}" 
                                {{ old('kategori', $menu->kategori) == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <div class="flex items-center mt-1 text-red-600 text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            
            <!-- Row 2: Harga & Stok -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="harga" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-money-bill-wave mr-1 text-gray-500"></i>
                        Harga
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-sm">Rp</span>
                        </div>
                        <input type="number" 
                               name="harga" 
                               id="harga" 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out @error('harga') border-red-500 @enderror" 
                               value="{{ old('harga', $menu->harga) }}" 
                               min="0" 
                               step="100" 
                               placeholder="0"
                               required>
                    </div>
                    @error('harga')
                        <div class="flex items-center mt-1 text-red-600 text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label for="stok" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-boxes mr-1 text-gray-500"></i>
                        Stok
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               name="stok" 
                               id="stok" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out @error('stok') border-red-500 @enderror" 
                               value="{{ old('stok', $menu->stok) }}" 
                               min="0" 
                               placeholder="0"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-sm">unit</span>
                        </div>
                    </div>
                    @error('stok')
                        <div class="flex items-center mt-1 text-red-600 text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            
            <!-- Deskripsi -->
            <div class="space-y-2">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-align-left mr-1 text-gray-500"></i>
                    Deskripsi
                </label>
                <textarea name="deskripsi" 
                          id="deskripsi" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out resize-none @error('deskripsi') border-red-500 @enderror" 
                          rows="4"
                          placeholder="Masukkan deskripsi menu (opsional)">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="flex items-center mt-1 text-red-600 text-sm">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <!-- Status Ketersediaan -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <input type="checkbox" 
                           name="tersedia" 
                           id="tersedia"
                           value="1" 
                           class="h-5 w-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500 focus:ring-2"
                           {{ old('tersedia', $menu->tersedia) ? 'checked' : '' }}>
                    <label for="tersedia" class="flex items-center text-sm font-medium text-gray-700 cursor-pointer">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        Menu Tersedia
                        <span class="ml-2 text-xs text-gray-500">(Centang jika menu tersedia untuk dijual)</span>
                    </label>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <a href="{{ route('menus.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-600 to-orange-500 hover:from-primary-700 hover:to-orange-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>
                        Update Menu
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Current Menu Info -->
<div class="mt-8 bg-gradient-to-r from-primary-50 to-orange-50 rounded-xl p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-info-circle mr-2 text-primary-600"></i>
        Informasi Menu Saat Ini
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <div class="text-sm text-gray-600 mb-1">Kategori</div>
            <div class="font-semibold text-primary-600">{{ $menu->kategori }}</div>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <div class="text-sm text-gray-600 mb-1">Harga</div>
            <div class="font-semibold text-green-600">{{ $menu->formatted_harga ?? 'Rp ' . number_format($menu->harga, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <div class="text-sm text-gray-600 mb-1">Stok</div>
            <div class="font-semibold {{ $menu->stok < 10 ? 'text-red-600' : 'text-blue-600' }}">
                {{ $menu->stok }} unit
            </div>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <div class="text-sm text-gray-600 mb-1">Status</div>
            <div class="font-semibold {{ $menu->tersedia ? 'text-green-600' : 'text-red-600' }}">
                {{ $menu->tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
            </div>
        </div>
    </div>
</div>

<style>
/* Custom styles for primary colors */
:root {
    --primary-50: #fef7ed;
    --primary-100: #fed7aa;
    --primary-500: #f97316;
    --primary-600: #ea580c;
    --primary-700: #c2410c;
}

.text-primary-600 { color: var(--primary-600); }
.text-primary-700 { color: var(--primary-700); }
.bg-primary-50 { background-color: var(--primary-50); }
.bg-primary-100 { background-color: var(--primary-100); }
.bg-primary-600 { background-color: var(--primary-600); }
.bg-primary-700 { background-color: var(--primary-700); }
.border-primary-500 { border-color: var(--primary-500); }
.ring-primary-500 { --tw-ring-color: var(--primary-500); }
.focus\:ring-primary-500:focus { --tw-ring-color: var(--primary-500); }
.focus\:border-primary-500:focus { border-color: var(--primary-500); }
.hover\:bg-primary-700:hover { background-color: var(--primary-700); }
.from-primary-600 { --tw-gradient-from: var(--primary-600); }
.to-primary-700 { --tw-gradient-to: var(--primary-700); }
.from-primary-50 { --tw-gradient-from: var(--primary-50); }
.hover\:from-primary-700:hover { --tw-gradient-from: var(--primary-700); }
</style>
@endsection