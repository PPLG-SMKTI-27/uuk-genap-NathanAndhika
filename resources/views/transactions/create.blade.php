<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Produk & Kategori (Kiri) -->
                <div class="md:w-2/3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Pilih Produk</h3>
                    
                    <!-- Kategori Filter (Simple) -->
                    <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-semibold whitespace-nowrap shadow hover:bg-blue-700 transition" onclick="filterCategory('all', this)">Semua</button>
                        @foreach($categories as $category)
                            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200 transition whitespace-nowrap" onclick="filterCategory({{ $category->id }}, this)">{{ $category->nama_kategori }}</button>
                        @endforeach
                    </div>

                    <!-- Daftar Produk -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($products as $product)
                            <div class="product-item p-4 border rounded-xl hover:shadow-lg hover:border-blue-400 cursor-pointer transition-all bg-white flex flex-col justify-between" data-category="{{ $product->category_id }}" onclick="addToCart({{ $product->id }}, '{{ $product->product_name }}', {{ $product->price }})">
                                <div>
                                    <div class="h-28 bg-gradient-to-br from-gray-100 to-gray-50 rounded-lg mb-3 flex items-center justify-center border border-gray-100 shadow-inner">
                                        <span class="text-gray-400 text-4xl">🛍️</span>
                                    </div>
                                    <h4 class="font-bold text-gray-800 line-clamp-2 leading-tight">{{ $product->product_name }}</h4>
                                </div>
                                <div class="mt-3 flex justify-between items-end">
                                    <p class="text-blue-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Stok: {{ $product->stock }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Keranjang & Form (Kanan) -->
                <div class="md:w-1/3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 h-fit border-t-4 border-blue-500">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Detail Transaksi</h3>
                    <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">No. Transaksi</label>
                                <input type="text" name="transaction_no" value="{{ $transactionNo }}" readonly class="mt-1 block w-full bg-gray-50 border-gray-200 rounded-md shadow-sm text-gray-500 sm:text-sm font-mono">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Tanggal</label>
                                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Status</label>
                                    <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-green-50 text-green-700 font-semibold">
                                        <option value="sudah bayar">Lunas</option>
                                        <option value="belum bayar">Belum Bayar</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Nama Pelanggan (Ops.)</label>
                                <input type="text" name="customer_name" placeholder="Umum" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="font-bold text-gray-700 mb-3 border-b border-gray-200 pb-2 flex justify-between">
                                <span>Keranjang</span>
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full" id="cart-badge">0 item</span>
                            </h4>
                            <div id="cart-items" class="min-h-[120px] max-h-[300px] overflow-y-auto pr-2 space-y-3">
                                <div id="empty-cart-msg" class="h-full flex flex-col items-center justify-center text-gray-400 mt-8">
                                    <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <p class="text-sm">Keranjang masih kosong</p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <div class="flex justify-between items-center font-bold text-xl text-gray-800 mb-6">
                                <span>Total</span>
                                <span id="total-price" class="text-blue-600">Rp 0</span>
                            </div>
                            
                            <button type="button" onclick="submitForm()" id="btn-submit" disabled class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Proses Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function filterCategory(categoryId, btn) {
            // Update button styles
            const buttons = btn.parentElement.querySelectorAll('button');
            buttons.forEach(b => {
                b.className = 'px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200 transition whitespace-nowrap';
            });
            btn.className = 'px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-semibold whitespace-nowrap shadow hover:bg-blue-700 transition';

            // Filter items
            const items = document.querySelectorAll('.product-item');
            items.forEach(item => {
                if (categoryId === 'all' || item.dataset.category == categoryId) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function addToCart(id, name, price) {
            const existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                existingItem.qty += 1;
            } else {
                cart.push({ id, name, price, qty: 1 });
            }
            renderCart();
        }

        function updateQty(id, delta) {
            const itemIndex = cart.findIndex(item => item.id === id);
            if (itemIndex > -1) {
                cart[itemIndex].qty += delta;
                if (cart[itemIndex].qty <= 0) {
                    cart.splice(itemIndex, 1);
                }
                renderCart();
            }
        }

        function renderCart() {
            const container = document.getElementById('cart-items');
            const emptyMsg = document.getElementById('empty-cart-msg');
            const totalEl = document.getElementById('total-price');
            const btnSubmit = document.getElementById('btn-submit');
            const cartBadge = document.getElementById('cart-badge');
            
            // Clear items but keep empty msg element
            container.innerHTML = '';
            
            let total = 0;
            let totalItems = 0;

            if (cart.length === 0) {
                container.appendChild(emptyMsg);
                emptyMsg.style.display = 'flex';
                totalEl.innerText = 'Rp 0';
                cartBadge.innerText = '0 item';
                btnSubmit.disabled = true;
                return;
            }

            cart.forEach((item, index) => {
                total += item.price * item.qty;
                totalItems += item.qty;
                
                const itemDiv = document.createElement('div');
                itemDiv.className = 'flex justify-between items-center bg-gray-50 p-2 rounded border border-gray-100';
                
                itemDiv.innerHTML = `
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-gray-800 line-clamp-1">${item.name}</p>
                        <p class="text-blue-600 text-xs font-medium">Rp ${(item.price * item.qty).toLocaleString('id-ID')}</p>
                    </div>
                    <div class="flex items-center gap-1 bg-white border rounded-md px-1">
                        <button type="button" onclick="updateQty(${item.id}, -1)" class="w-6 h-6 text-gray-500 hover:text-red-500 flex items-center justify-center font-bold transition-colors">-</button>
                        <span class="w-5 text-center text-sm font-semibold">${item.qty}</span>
                        <button type="button" onclick="updateQty(${item.id}, 1)" class="w-6 h-6 text-gray-500 hover:text-green-500 flex items-center justify-center font-bold transition-colors">+</button>
                    </div>
                    
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
                `;
                
                container.appendChild(itemDiv);
            });

            totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
            cartBadge.innerText = `${totalItems} item`;
            btnSubmit.disabled = false;
        }

        function submitForm() {
            if (cart.length > 0) {
                document.getElementById('transactionForm').submit();
            }
        }
    </script>
</x-app-layout>
