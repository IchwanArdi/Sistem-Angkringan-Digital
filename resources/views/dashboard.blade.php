@extends('layouts.app')

@section('title', 'Dashboard - Sistem Angkringan')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl shadow-lg p-6 text-white">
        <h1 class="text-3xl font-bold flex items-center">
            <i class="fas fa-tachometer-alt mr-3"></i>
            {{ auth()->user()->nama_angkringan }}
        </h1>
        <p class="mt-2 text-primary-100">Selamat datang di sistem pengelolaan angkringan Anda</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Menu Card -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Menu</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalMenu }}</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ $menuTersedia }} tersedia
                    </p>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fas fa-utensils text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-blue-50 px-6 py-3">
            <div class="text-xs text-blue-600 font-medium">
                <i class="fas fa-info-circle mr-1"></i>
                Menu dalam sistem
            </div>
        </div>
    </div>

    <!-- Pesanan Hari Ini Card -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pesanan Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pesananHariIni }}</p>
                    <p class="text-sm text-orange-600 mt-1">
                        <i class="fas fa-clock mr-1"></i>
                        Hari ini
                    </p>
                </div>
                <div class="bg-orange-100 rounded-full p-4">
                    <i class="fas fa-shopping-cart text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-orange-50 px-6 py-3">
            <div class="text-xs text-orange-600 font-medium">
                <i class="fas fa-calendar-day mr-1"></i>
                Total pesanan
            </div>
        </div>
    </div>

    <!-- Pemasukan Hari Ini Card -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pemasukan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalPemasukanHariIni, 0, ',', '.') }}</p>
                    <p class="text-sm text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>
                        Pendapatan harian
                    </p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <i class="fas fa-money-bill-wave text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-green-50 px-6 py-3">
            <div class="text-xs text-green-600 font-medium">
                <i class="fas fa-coins mr-1"></i>
                Total hari ini
            </div>
        </div>
    </div>

    <!-- Pemasukan Bulan Ini Card -->
    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pemasukan Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalPemasukanBulanIni, 0, ',', '.') }}</p>
                    <p class="text-sm text-purple-600 mt-1">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Pendapatan bulanan
                    </p>
                </div>
                <div class="bg-purple-100 rounded-full p-4">
                    <i class="fas fa-chart-line text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-purple-50 px-6 py-3">
            <div class="text-xs text-purple-600 font-medium">
                <i class="fas fa-trending-up mr-1"></i>
                Total bulan ini
            </div>
        </div>
    </div>
</div>

<!-- Content Cards -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Pesanan Terbaru -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-list-alt mr-2"></i>
                Pesanan Terbaru
            </h3>
        </div>
        <div class="p-6">
            @if($pesananTerbaru->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kode Order
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pesananTerbaru as $pesanan)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $pesanan->kode_order }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $pesanan->formatted_total_harga }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($pesanan->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($pesanan->status == 'selesai') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        @if($pesanan->status == 'pending')
                                            <i class="fas fa-clock mr-1"></i>
                                        @elseif($pesanan->status == 'selesai')
                                            <i class="fas fa-check mr-1"></i>
                                        @else
                                            <i class="fas fa-times mr-1"></i>
                                        @endif
                                        {{ ucfirst($pesanan->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pesanan->formatted_created_at }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-2xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 text-lg">Belum ada pesanan hari ini</p>
                    <p class="text-gray-400 text-sm mt-1">Pesanan akan muncul di sini ketika ada pelanggan yang memesan</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Menu Hampir Habis -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Menu Hampir Habis
                <span class="ml-2 bg-red-400 text-xs px-2 py-1 rounded-full">Stok < 10</span>
            </h3>
        </div>
        <div class="p-6">
            @if($menuHampirHabis->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Menu
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stok
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($menuHampirHabis as $menu)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $menu->nama }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                        {{ $menu->kategori }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-sm font-bold bg-red-100 text-red-800 rounded-full items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $menu->stok }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lightbulb text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Tips:</strong> Segera lakukan restok untuk menu yang hampir habis agar tidak kehabisan stok saat ada pesanan.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-2xl text-green-500"></i>
                    </div>
                    <p class="text-green-600 text-lg font-medium">Semua menu masih aman stoknya</p>
                    <p class="text-gray-400 text-sm mt-1">Tidak ada menu yang perlu di-restok saat ini</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-gradient-to-r from-primary-50 to-orange-50 rounded-xl p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-bolt mr-2 text-primary-600"></i>
        Aksi Cepat
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('menus.index') }}" 
           class="bg-white hover:bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 transition-all duration-200 hover:shadow-md group">
            <div class="flex items-center">
                <div class="bg-blue-100 group-hover:bg-blue-200 rounded-lg p-3 mr-3">
                    <i class="fas fa-utensils text-blue-600"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Kelola Menu</p>
                    <p class="text-sm text-gray-500">Tambah, edit, hapus menu</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('orders.index') }}" 
           class="bg-white hover:bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 transition-all duration-200 hover:shadow-md group">
            <div class="flex items-center">
                <div class="bg-orange-100 group-hover:bg-orange-200 rounded-lg p-3 mr-3">
                    <i class="fas fa-shopping-cart text-orange-600"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Kelola Pesanan</p>
                    <p class="text-sm text-gray-500">Lihat dan proses pesanan</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('reports.index') }}" 
           class="bg-white hover:bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 transition-all duration-200 hover:shadow-md group">
            <div class="flex items-center">
                <div class="bg-green-100 group-hover:bg-green-200 rounded-lg p-3 mr-3">
                    <i class="fas fa-chart-bar text-green-600"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Lihat Laporan</p>
                    <p class="text-sm text-gray-500">Analisis penjualan</p>
                </div>
            </div>
        </a>
        
        <div class="bg-white hover:bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 transition-all duration-200 hover:shadow-md group cursor-pointer"
             onclick="window.location.reload()">
            <div class="flex items-center">
                <div class="bg-purple-100 group-hover:bg-purple-200 rounded-lg p-3 mr-3">
                    <i class="fas fa-sync-alt text-purple-600"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Refresh Data</p>
                    <p class="text-sm text-gray-500">Perbarui informasi</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection