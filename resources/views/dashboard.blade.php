<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Sembako Mart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="bg-blue-600 text-white p-6 rounded-2xl shadow-md">
                    <p class="text-sm font-medium opacity-80">Total Produk</p>
                    <h3 class="text-3xl font-bold mt-1">{{ $totalProducts ?? 0 }}</h3>
                </div>
                <div class="bg-purple-600 text-white p-6 rounded-2xl shadow-md">
                    <p class="text-sm font-medium opacity-80">Total Kategori</p>
                    <h3 class="text-3xl font-bold mt-1">{{ $totalCategories ?? 0 }}</h3>
                </div>
                <div class="bg-emerald-600 text-white p-6 rounded-2xl shadow-md">
                    <p class="text-sm font-medium opacity-80">Barang Masuk</p>
                    <h3 class="text-3xl font-bold mt-1">{{ $totalStockIn ?? 0 }}</h3>
                </div>
                <div class="bg-amber-600 text-white p-6 rounded-2xl shadow-md">
                    <p class="text-sm font-medium opacity-80">Barang Keluar</p>
                    <h3 class="text-3xl font-bold mt-1">{{ $totalStockOut ?? 0 }}</h3>
                </div>
                <div class="bg-rose-600 text-white p-6 rounded-2xl shadow-md">
                    <p class="text-sm font-medium opacity-80">Stok Rendah</p>
                    <h3 class="text-3xl font-bold mt-1">{{ $lowStockCount ?? 0 }}</h3>
                </div>
            </div>

            <!-- Panel Akses Cepat -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border border-emerald-100 flex flex-wrap gap-4 items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Panel Akses Cepat</h3>
                    <p class="text-xs text-gray-500">Kelola menu inventori, transaksi, dan sesi akun Anda.</p>
                </div>
                
                <div class="flex flex-wrap gap-3 items-center">
                    <!-- Tombol khusus Admin -->
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('categories.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow">Kelola Kategori</a>
                        <a href="{{ route('suppliers.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow">Kelola Supplier</a>
                    @endif

                    <!-- Tombol untuk Admin & Staff -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                        <a href="{{ route('products.index') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow">Kelola Produk</a>
                        <a href="{{ route('sales.index') }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow">Riwayat Transaksi</a>
                    @endif

                    <!-- Tombol untuk User & Semua Role: Riwayat / Daftar Pesanan -->
                    <a href="{{ route('orders.index') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow">
                        📦 {{ auth()->user()->role === 'user' ? 'Riwayat Pesanan Saya' : 'Kelola Pesanan Masuk' }}
                    </a>

                    <!-- Tombol Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="inline-block">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- KATALOG PRODUK SEMBAKO -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Katalog Produk Sembako Tersedia</h3>
                        <p class="text-xs text-gray-500">Dapat dilihat langsung oleh Admin, Staff, dan User</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($products as $product)
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col justify-between p-4">
                            <div>
                                <!-- Foto Produk -->
                                <div class="h-44 w-full bg-gray-100 overflow-hidden relative rounded-xl mb-3">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400 text-xs font-medium">Tanpa Foto</div>
                                    @endif
                                    <span class="absolute top-2 right-2 bg-emerald-600 text-white text-xs font-semibold px-2.5 py-1 rounded-lg shadow">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>

                                <!-- Detail Produk -->
                                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md">{{ $product->category->name ?? 'Umum' }}</span>
                                <p class="text-xs font-mono text-gray-400 mt-2">SKU: {{ $product->sku }}</p>
                                <h4 class="font-bold text-gray-800 text-base mt-1 truncate">{{ $product->name }}</h4>
                                @php
                                    $pPrice = $product->selling_price ?? $product->price ?? $product->harga ?? $product->harga_jual ?? 0;
                                @endphp
                                <p class="text-emerald-700 font-extrabold text-lg mt-2">Rp {{ number_format($pPrice, 0, ',', '.') }}</p>
                            </div>

                            <!-- Tombol Pesan Sekarang (Khusus User) untuk membuka Modal -->
                            @if(auth()->user()->role === 'user')
                                <div class="mt-4 pt-3 border-t border-gray-100">
                                    <button type="button" onclick="openOrderModal('{{ $product->id }}', '{{ addslashes($product->name) }}', '{{ $product->stock }}')" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold py-2.5 rounded-xl shadow transition">
                                        🛒 Pesan Sekarang
                                    </button>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full text-center py-10 text-gray-400 italic">
                            Belum ada produk sembako yang dimasukkan ke dalam sistem.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- TABEL LIST PRODUK YANG STOKNYA MENIPIS (<= 5) -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-rose-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-rose-800">⚠️ Daftar Produk dengan Stok Menipis (≤ 5 pcs)</h3>
                        <p class="text-xs text-gray-500">Daftar barang yang perlu segera dilakukan penambahan stok (*restock*).</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="py-3 px-4 text-left">No</th>
                                <th class="py-3 px-4 text-left">Kode SKU</th>
                                <th class="py-3 px-4 text-left">Nama Produk</th>
                                <th class="py-3 px-4 text-left">Kategori</th>
                                <th class="py-3 px-4 text-left">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($lowStockProducts as $index => $item)
                                <tr class="hover:bg-rose-50/50 transition">
                                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-mono font-medium text-rose-600">{{ $item->sku }}</td>
                                    <td class="py-3 px-4 font-semibold text-gray-800">{{ $item->name }}</td>
                                    <td class="py-3 px-4">
                                        <span class="bg-rose-50 text-rose-700 text-xs font-medium px-2.5 py-1 rounded-md">
                                            {{ $item->category->name ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-rose-600">{{ $item->stock }} pcs</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-400 italic">Aman! Belum ada produk dengan stok menipis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL POP-UP FORM PEMESANAN -->
    <div id="orderModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 relative transform transition-all">
            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 class="text-lg font-bold text-gray-800">Form Pemesanan Sembako</h3>
                <button type="button" onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>

            <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="product_id" id="modal_product_id">

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Produk Dipilih</label>
                    <input type="text" id="modal_product_name" disabled class="w-full text-xs rounded-xl bg-gray-100 border-gray-300 text-gray-600 font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap Pemesan</label>
                    <input type="text" name="customer_name" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Masukkan nama lengkap...">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Jumlah (Qty)</label>
                        <input type="number" name="quantity" id="modal_quantity" value="1" min="1" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                        <input type="text" name="phone" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                    <textarea name="shipping_address" rows="3" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Masukkan alamat lengkap pengiriman..."></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" onclick="closeOrderModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-medium px-4 py-2 rounded-xl transition">Batal</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-5 py-2 rounded-xl shadow transition">Kirim Pesanan Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT MODAL -->
    <script>
        function openOrderModal(productId, productName, productStock) {
            document.getElementById('modal_product_id').value = productId;
            document.getElementById('modal_product_name').value = productName;
            document.getElementById('modal_quantity').max = productStock;
            document.getElementById('orderModal').classList.remove('hidden');
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
        }
    </script>
</x-app-layout>