@extends('layouts.app')

@section('title', 'Tambah Menu - Sistem Angkringan')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-plus-circle mr-3 text-primary-600"></i>
                Tambah Menu Baru
            </h1>
            <p class="mt-2 text-gray-600">Tambahkan menu baru ke dalam sistem angkringan</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('menus.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Menu
            </a>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
        <h3 class="text-lg font-semibold text-white flex items-center">
            <i class="fas fa-utensils mr-2"></i>
            Form Tambah Menu
        </h3>
    </div>
    
    <div class="p-6">
        <form method="POST" action="{{ route('menus.store') }}" class="space-y-6">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="border-b border-gray-200 pb-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    Informasi Dasar
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Menu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out @error('nama') border-red-500 @enderror" 
                               value="{{ old('nama') }}" required
                               placeholder="Masukkan nama menu">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori" id="kategori" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out @error('kategori') border-red-500 @enderror" 
                                required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori }}" 
                                    {{ old('kategori') == $kategori ? 'selected' : '' }}>
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Pricing & Stock Section -->
            <div class="border-b border-gray-200 pb-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-tags mr-2 text-green-500"></i>
                    Harga & Stok
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga" id="harga" 
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out @error('harga') border-red-500 @enderror" 
                                   value="{{ old('harga') }}" min="0" step="100" required
                                   placeholder="0">
                        </div>
                        @error('harga')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="stok" id="stok" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out @error('stok') border-red-500 @enderror" 
                                   value="{{ old('stok') }}" min="0" required
                                   placeholder="Jumlah stok">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">unit</span>
                            </div>
                        </div>
                        @error('stok')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Description Section -->
            <div class="border-b border-gray-200 pb-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-align-left mr-2 text-purple-500"></i>
                    Deskripsi
                </h4>
                
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Menu (Opsional)
                    </label>
                    <textarea name="deskripsi" id="deskripsi" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-150 ease-in-out @error('deskripsi') border-red-500 @enderror"
                              rows="4" 
                              placeholder="Masukkan deskripsi menu (misalnya: bahan, rasa, dll)">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            
            <!-- Availability Section -->
            <div class="pb-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-toggle-on mr-2 text-orange-500"></i>
                    Status Ketersediaan
                </h4>
                
                <div class="flex items-center">
                    <input type="checkbox" name="tersedia" id="tersedia" value="1" 
                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded transition duration-150 ease-in-out"
                           {{ old('tersedia', true) ? 'checked' : '' }}>
                    <label for="tersedia" class="ml-3 flex items-center">
                        <span class="text-sm font-medium text-gray-700">Menu Tersedia</span>
                        <span class="ml-2 text-xs text-gray-500">(Centang jika menu siap dijual)</span>
                    </label>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                <button type="submit" 
                        class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Menu
                </button>
                <a href="{{ route('menus.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tips Card -->
<div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
    <h3 class="text-lg font-semibold text-blue-900 mb-3 flex items-center">
        <i class="fas fa-lightbulb mr-2 text-blue-600"></i>
        Tips Menambah Menu
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-blue-800">
        <div class="flex items-start">
            <i class="fas fa-check-circle mr-2 text-blue-600 mt-0.5"></i>
            <div>
                <strong>Nama Menu:</strong> Gunakan nama yang jelas dan mudah dipahami pelanggan
            </div>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle mr-2 text-blue-600 mt-0.5"></i>
            <div>
                <strong>Harga:</strong> Pastikan harga sesuai dengan kualitas dan porsi menu
            </div>
        </div>
        <div class="flex items-start">
            <i class="fas fa-check-circle mr-2 text-blue-600 mt-0.5"></i>
            <div>
                <strong>Stok:</strong> Update stok secara berkala untuk menghindari kehabisan
            </div>
        </div>
    </div>
</div>
@endsection