@extends('layouts.app')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-plus-circle text-primary-600 mr-3"></i>
                    Buat Pesanan Baru
                </h1>
                <p class="mt-2 text-gray-600">Pilih menu favorit Anda dan buat pesanan dengan mudah</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('orders.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <ul class="text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('orders.store') }}" id="orderForm">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Menu Selection -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-utensils mr-3"></i>
                            Pilih Menu Favorit
                        </h2>
                        <p class="text-primary-100 text-sm mt-1">Klik "Tambah" untuk memasukkan menu ke keranjang</p>
                    </div>
                    <div class="p-6">
                        @if($kategoris->count() > 0)
                            @foreach($kategoris as $kategori => $menuList)
                                <div class="mb-8 last:mb-0">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-primary-100 rounded-full p-2 mr-3">
                                            <i class="fas fa-tag text-primary-600"></i>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $kategori }}</h3>
                                        <div class="flex-1 ml-4 border-t border-gray-200"></div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($menuList as $menu)
                                            <div class="menu-item bg-white border border-gray-200 rounded-lg p-4 hover:shadow-lg hover:border-primary-300 transition duration-300 transform hover:-translate-y-1" 
                                                 data-menu-id="{{ $menu->id }}" 
                                                 data-menu-name="{{ $menu->nama }}" 
                                                 data-menu-price="{{ $menu->harga }}" 
                                                 data-menu-stock="{{ $menu->stok }}">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <h4 class="font-semibold text-gray-900 mb-2">{{ $menu->nama }}</h4>
                                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $menu->deskripsi }}</p>
                                                        <div class="flex items-center justify-between">
                                                            <div>
                                                                <span class="text-2xl font-bold text-primary-600">{{ $menu->formatted_harga }}</span>
                                                                <div class="flex items-center mt-1">
                                                                    <i class="fas fa-boxes text-gray-400 text-xs mr-1"></i>
                                                                    <span class="text-xs text-gray-500">Stok: {{ $menu->stok }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        @if($menu->stok > 0)
                                                            <button type="button" 
                                                                    class="add-menu-btn bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center shadow-sm">
                                                                <i class="fas fa-plus mr-2"></i>
                                                                Tambah
                                                            </button>
                                                        @else
                                                            <button type="button" 
                                                                    class="bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed flex items-center" 
                                                                    disabled>
                                                                <i class="fas fa-times mr-2"></i>
                                                                Habis
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-12">
                                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-utensils text-gray-400 text-3xl"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada menu tersedia</h3>
                                <p class="text-gray-600">Belum ada menu yang tersedia untuk dipesan saat ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-6">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4 rounded-t-lg">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-shopping-cart mr-3"></i>
                            Keranjang Pesanan
                        </h2>
                    </div>
                    <div class="p-6">
                        <div id="orderItems" class="mb-6">
                            <div class="text-center py-8" id="emptyOrder">
                                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-shopping-basket text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500">Keranjang masih kosong</p>
                                <p class="text-sm text-gray-400 mt-1">Pilih menu untuk memulai pesanan</p>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Total Pembayaran:</span>
                                <span class="text-2xl font-bold text-primary-600" id="totalPrice">Rp 0</span>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sticky-note mr-2"></i>
                                Catatan Pesanan
                            </label>
                            <textarea name="catatan" 
                                      id="catatan" 
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200" 
                                      rows="3" 
                                      placeholder="Tambahkan catatan khusus untuk pesanan Anda...">{{ old('catatan') }}</textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center" 
                                id="submitOrder" 
                                disabled>
                            <i class="fas fa-check-circle mr-2"></i>
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let orderItems = [];
    let totalPrice = 0;

    const orderItemsContainer = document.getElementById('orderItems');
    const emptyOrder = document.getElementById('emptyOrder');
    const totalPriceElement = document.getElementById('totalPrice');
    const submitOrderBtn = document.getElementById('submitOrder');

    // Add menu item to order
    document.querySelectorAll('.add-menu-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const menuCard = this.closest('.menu-item');
            const menuId = parseInt(menuCard.dataset.menuId);
            const menuName = menuCard.dataset.menuName;
            const menuPrice = parseFloat(menuCard.dataset.menuPrice);
            const menuStock = parseInt(menuCard.dataset.menuStock);

            // Check if item already exists
            const existingItem = orderItems.find(item => item.menuId === menuId);
            
            if (existingItem) {
                if (existingItem.quantity < menuStock) {
                    existingItem.quantity++;
                    updateOrderDisplay();
                } else {
                    alert('Stok tidak mencukupi!');
                }
            } else {
                orderItems.push({
                    menuId: menuId,
                    menuName: menuName,
                    menuPrice: menuPrice,
                    quantity: 1,
                    maxStock: menuStock
                });
                updateOrderDisplay();
            }
        });
    });

    function updateOrderDisplay() {
        orderItemsContainer.innerHTML = '';
        totalPrice = 0;

        if (orderItems.length === 0) {
            orderItemsContainer.appendChild(emptyOrder);
            submitOrderBtn.disabled = true;
        } else {
            emptyOrder.style.display = 'none';
            submitOrderBtn.disabled = false;

            orderItems.forEach((item, index) => {
                const subtotal = item.menuPrice * item.quantity;
                totalPrice += subtotal;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'bg-gray-50 rounded-lg p-4 mb-3 border border-gray-200';
                itemDiv.innerHTML = `
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">${item.menuName}</h4>
                            <p class="text-sm text-gray-600">Rp ${item.menuPrice.toLocaleString('id-ID')} / item</p>
                        </div>
                        <button type="button" class="remove-item text-red-500 hover:text-red-700 p-1" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center bg-white rounded-lg border border-gray-300">
                            <button type="button" class="decrease-qty p-2 hover:bg-gray-100 rounded-l-lg" data-index="${index}">
                                <i class="fas fa-minus text-gray-600"></i>
                            </button>
                            <span class="px-4 py-2 font-semibold text-gray-900">${item.quantity}</span>
                            <button type="button" class="increase-qty p-2 hover:bg-gray-100 rounded-r-lg ${item.quantity >= item.maxStock ? 'opacity-50 cursor-not-allowed' : ''}" data-index="${index}" ${item.quantity >= item.maxStock ? 'disabled' : ''}>
                                <i class="fas fa-plus text-gray-600"></i>
                            </button>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-primary-600">Rp ${subtotal.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                    <input type="hidden" name="items[${index}][menu_id]" value="${item.menuId}">
                    <input type="hidden" name="items[${index}][jumlah]" value="${item.quantity}">
                `;
                orderItemsContainer.appendChild(itemDiv);
            });
        }

        totalPriceElement.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;

        // Add event listeners for quantity controls
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                orderItems.splice(index, 1);
                updateOrderDisplay();
            });
        });

        document.querySelectorAll('.decrease-qty').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                if (orderItems[index].quantity > 1) {
                    orderItems[index].quantity--;
                    updateOrderDisplay();
                }
            });
        });

        document.querySelectorAll('.increase-qty').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                if (orderItems[index].quantity < orderItems[index].maxStock) {
                    orderItems[index].quantity++;
                    updateOrderDisplay();
                }
            });
        });
    }
});
</script>

<style>
.menu-item {
    transition: all 0.3s ease;
}

.menu-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection