@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-receipt text-primary-600 mr-3"></i>
                    Detail Pesanan
                </h1>
                <p class="text-gray-600 mt-2">Informasi lengkap pesanan angkringan</p>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('orders.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm animate-fade-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-primary-50 to-orange-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle text-primary-600 mr-2"></i>
                        Informasi Pesanan
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 font-medium">Kode Order:</span>
                                <span class="text-gray-900 font-bold text-lg">{{ $order->kode_order }}</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 font-medium">Tanggal:</span>
                                <span class="text-gray-900 font-semibold">{{ $order->formatted_created_at }}</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 font-medium">Status:</span>
                                <div>
                                    @if($order->status == 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-2"></i>
                                            Pending
                                        </span>
                                    @elseif($order->status == 'selesai')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-2"></i>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-2"></i>
                                            Dibatalkan
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-primary-50 to-orange-50 rounded-lg border border-primary-100">
                                <span class="text-gray-600 font-medium">Total Harga:</span>
                                <span class="text-primary-600 font-bold text-2xl">{{ $order->formatted_total_harga }}</span>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 font-medium block mb-2">Catatan:</span>
                                <span class="text-gray-900">{{ $order->catatan ?? 'Tidak ada catatan khusus' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-primary-50 to-orange-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-utensils text-primary-600 mr-2"></i>
                        Item Pesanan
                    </h3>
                </div>
                
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->orderItems as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $item->menu->nama }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-primary-100 text-primary-800">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ $item->menu->kategori }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $item->formatted_harga_satuan }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $item->jumlah }}x
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-primary-600">{{ $item->formatted_subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <th colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Total Pesanan:</th>
                                <th class="px-6 py-4 text-sm font-bold text-primary-600 text-lg">{{ $order->formatted_total_harga }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden p-4 space-y-4">
                    @foreach($order->orderItems as $item)
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $item->menu->nama }}</h4>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-primary-100 text-primary-800 mt-1">
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $item->menu->kategori }}
                                    </span>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $item->jumlah }}x
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-gray-500">Harga Satuan:</span>
                                    <div class="font-medium">{{ $item->formatted_harga_satuan }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-500">Subtotal:</span>
                                    <div class="font-bold text-primary-600">{{ $item->formatted_subtotal }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Mobile Total -->
                    <div class="bg-gradient-to-r from-primary-50 to-orange-50 rounded-lg p-4 border border-primary-100">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-900 font-semibold">Total Pesanan:</span>
                            <span class="text-primary-600 font-bold text-xl">{{ $order->formatted_total_harga }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-primary-50 to-orange-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-cogs text-primary-600 mr-2"></i>
                        Aksi Pesanan
                    </h3>
                </div>
                <div class="p-6">
                    @if($order->status == 'pending')
                        <div class="space-y-3">
                            <form method="POST" action="{{ route('orders.update-status', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200"
                                        onclick="return confirm('Tandai pesanan sebagai selesai?')">
                                    <i class="fas fa-check mr-2"></i>
                                    Tandai Selesai
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('orders.update-status', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="dibatalkan">
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200"
                                        onclick="return confirm('Batalkan pesanan ini? Stok akan dikembalikan.')">
                                    <i class="fas fa-times mr-2"></i>
                                    Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400 text-lg"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-blue-700 font-medium">
                                        @if($order->status == 'selesai')
                                            Pesanan ini sudah selesai dan tidak dapat diubah.
                                        @else
                                            Pesanan ini sudah dibatalkan dan tidak dapat diubah.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-primary-50 to-orange-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-pie text-primary-600 mr-2"></i>
                        Ringkasan Pesanan
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600 font-medium flex items-center">
                            <i class="fas fa-shopping-cart text-gray-400 mr-2"></i>
                            Jumlah Item:
                        </span>
                        <span class="text-gray-900 font-bold">{{ $order->orderItems->sum('jumlah') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600 font-medium flex items-center">
                            <i class="fas fa-utensils text-gray-400 mr-2"></i>
                            Jenis Menu:
                        </span>
                        <span class="text-gray-900 font-bold">{{ $order->orderItems->count() }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-primary-50 to-orange-50 rounded-lg border border-primary-100">
                            <span class="text-gray-900 font-semibold flex items-center">
                                <i class="fas fa-calculator text-primary-600 mr-2"></i>
                                Total Harga:
                            </span>
                            <span class="text-primary-600 font-bold text-xl">{{ $order->formatted_total_harga }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-primary-50 to-orange-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt text-primary-600 mr-2"></i>
                        Aksi Cepat
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('orders.index') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-list mr-2"></i>
                        Lihat Semua Pesanan
                    </a>
                    <a href="{{ route('orders.create') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-100 hover:bg-primary-200 text-primary-700 font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Pesanan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection