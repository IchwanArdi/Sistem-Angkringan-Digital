@extends('layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-list-alt text-primary-600 mr-3"></i>
                    Daftar Pesanan
                </h1>
                <p class="text-gray-600 mt-2">Kelola dan pantau semua pesanan angkringan</p>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('orders.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-lg shadow-lg hover:from-primary-700 hover:to-primary-800 transform hover:scale-105 transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Pesanan Baru
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

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm animate-fade-in">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-filter text-primary-600 mr-2"></i>
            Filter Pesanan
        </h3>
        <form method="GET" action="{{ route('orders.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                           value="{{ request('tanggal') }}">
                </div>
                <div class="flex items-end space-x-3">
                    <button type="submit" 
                            class="px-6 py-2 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('orders.index') }}" 
                       class="px-6 py-2 bg-gray-500 text-white font-medium rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-200">
                        <i class="fas fa-undo mr-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Orders Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($orders->count() > 0)
            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kode Order
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Harga
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Catatan
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-receipt text-primary-500 mr-3"></i>
                                        <span class="text-sm font-bold text-gray-900">{{ $order->kode_order }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $order->formatted_created_at }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $order->formatted_total_harga }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($order->status == 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Pending
                                        </span>
                                    @elseif($order->status == 'selesai')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-1"></i>
                                            Dibatalkan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                    {{ $order->catatan ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                                    <a href="{{ route('orders.show', $order) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full hover:bg-blue-200 transition-colors duration-150">
                                        <i class="fas fa-eye mr-1"></i>
                                        Detail
                                    </a>
                                    
                                    @if($order->status == 'pending')
                                        <form method="POST" action="{{ route('orders.update-status', $order) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full hover:bg-green-200 transition-colors duration-150"
                                                    onclick="return confirm('Tandai pesanan sebagai selesai?')">
                                                <i class="fas fa-check mr-1"></i>
                                                Selesai
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('orders.update-status', $order) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="dibatalkan">
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full hover:bg-red-200 transition-colors duration-150"
                                                    onclick="return confirm('Batalkan pesanan ini?')">
                                                <i class="fas fa-times mr-1"></i>
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden p-4 space-y-4">
                @foreach($orders as $order)
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center">
                                <i class="fas fa-receipt text-primary-500 mr-2"></i>
                                <span class="font-bold text-gray-900">{{ $order->kode_order }}</span>
                            </div>
                            @if($order->status == 'pending')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Pending
                                </span>
                            @elseif($order->status == 'selesai')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>
                                    Dibatalkan
                                </span>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-500">Tanggal:</span>
                                <div class="font-medium">{{ $order->formatted_created_at }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">Total:</span>
                                <div class="font-semibold text-primary-600">{{ $order->formatted_total_harga }}</div>
                            </div>
                        </div>
                        
                        @if($order->catatan)
                            <div class="text-sm">
                                <span class="text-gray-500">Catatan:</span>
                                <div class="text-gray-700">{{ $order->catatan }}</div>
                            </div>
                        @endif
                        
                        <div class="flex flex-wrap gap-2 pt-2">
                            <a href="{{ route('orders.show', $order) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                <i class="fas fa-eye mr-1"></i>
                                Detail
                            </a>
                            
                            @if($order->status == 'pending')
                                <form method="POST" action="{{ route('orders.update-status', $order) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full"
                                            onclick="return confirm('Tandai pesanan sebagai selesai?')">
                                        <i class="fas fa-check mr-1"></i>
                                        Selesai
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('orders.update-status', $order) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="dibatalkan">
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full"
                                            onclick="return confirm('Batalkan pesanan ini?')">
                                        <i class="fas fa-times mr-1"></i>
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 mb-6">
                        <i class="fas fa-clipboard-list text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pesanan ditemukan</h3>
                    <p class="text-gray-500 mb-6">Belum ada pesanan yang dibuat atau sesuai dengan filter yang dipilih.</p>
                    <a href="{{ route('orders.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-lg shadow-lg hover:from-primary-700 hover:to-primary-800 transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Pesanan Pertama
                    </a>
                </div>
            </div>
        @endif
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