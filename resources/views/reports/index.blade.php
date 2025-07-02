@extends('layouts.app')

@section('title', 'Laporan Penjualan - Sistem Angkringan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            <i class="fas fa-chart-line text-blue-600 mr-3"></i>
            Laporan Penjualan
        </h1>
        <p class="text-gray-600">Analisis detail penjualan dan performa menu</p>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalOrders) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                    <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-chart-bar text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Rata-rata/Hari</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        Rp {{ $dailyStats->count() > 0 ? number_format($dailyStats->avg('daily_revenue'), 0, ',', '.') : '0' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-utensils text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Menu Terjual</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $topMenus->sum('total_sold') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Menu Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-trophy text-yellow-600 mr-2"></i>
            Menu Terlaris
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Ranking</th>
                        <th class="px-6 py-3">Nama Menu</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Terjual</th>
                        <th class="px-6 py-3">Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topMenus as $index => $menu)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">
                            @if($index == 0)
                                <span class="text-yellow-500"><i class="fas fa-crown"></i></span>
                            @elseif($index == 1)
                                <span class="text-gray-400"><i class="fas fa-medal"></i></span>
                            @elseif($index == 2)
                                <span class="text-orange-500"><i class="fas fa-medal"></i></span>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $menu->nama }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($menu->kategori == 'Nasi') bg-red-100 text-red-800
                                @elseif($menu->kategori == 'Gorengan') bg-yellow-100 text-yellow-800
                                @elseif($menu->kategori == 'Minuman') bg-blue-100 text-blue-800
                                @elseif($menu->kategori == 'Cemilan') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $menu->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ number_format($menu->total_sold) }} item</td>
                        <td class="px-6 py-4 font-medium text-green-600">Rp {{ number_format($menu->total_revenue, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data menu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Daily Statistics -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-calendar-day text-purple-600 mr-2"></i>
            Statistik Harian
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Total Pesanan</th>
                        <th class="px-6 py-3">Pendapatan</th>
                        <th class="px-6 py-3">Rata-rata per Pesanan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailyStats as $stat)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ \Carbon\Carbon::parse($stat->date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ number_format($stat->order_count) }}</td>
                        <td class="px-6 py-4 font-medium text-green-600">Rp {{ number_format($stat->daily_revenue, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($stat->daily_revenue / $stat->order_count, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data penjualan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Category Statistics -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-tags text-indigo-600 mr-2"></i>
            Statistik per Kategori
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($categoryStats as $category)
            <div class="border rounded-lg p-4 hover:shadow-md transition duration-200">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-medium text-gray-900">{{ $category->kategori }}</h4>
                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                        @if($category->kategori == 'Nasi') bg-red-100 text-red-800
                        @elseif($category->kategori == 'Gorengan') bg-yellow-100 text-yellow-800
                        @elseif($category->kategori == 'Minuman') bg-blue-100 text-blue-800
                        @elseif($category->kategori == 'Cemilan') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $category->total_quantity }} item
                    </span>
                </div>
                <p class="text-lg font-semibold text-green-600">Rp {{ number_format($category->total_revenue, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500">
                    {{ number_format(($category->total_revenue / $totalRevenue) * 100, 1) }}% dari total
                </p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Daily Revenue Chart
    const dailyCtx = document.getElementById('dailyRevenueChart');
    if (dailyCtx) {
        const dailyData = @json($dailyStats->map(function($stat) {
            return [
                'date' => \Carbon\Carbon::parse($stat->date)->format('d/m'),
                'revenue' => $stat->daily_revenue
            ];
        })->values());

        new Chart(dailyCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: dailyData.map(d => d.date),
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: dailyData.map(d => d.revenue),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        const categoryData = @json($categoryStats);
        const colors = ['#ef4444', '#f59e0b', '#3b82f6', '#10b981', '#6b7280'];

        new Chart(categoryCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: categoryData.map(c => c.kategori),
                datasets: [{
                    data: categoryData.map(c => c.total_revenue),
                    backgroundColor: colors.slice(0, categoryData.length),
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endsection