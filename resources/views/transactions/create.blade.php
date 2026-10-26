<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Catat Transaksi Sembako') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-8">
                
                <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi</label>
                        <select name="type" id="type" required class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" onchange="toggleTransactionFields()">
                            <option value="purchase" {{ old('type') == 'purchase' ? 'selected' : '' }}>Barang Masuk / Pembelian (Menambah Stok)</option>
                            <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>Barang Keluar / Penjualan (Mengurangi Stok)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Produk Sembako</label>
                        <select name="product_id" required class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Stok saat ini: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Supplier (Hanya tampil saat Pembelian) -->
                    <div id="supplier-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Supplier (Wajib diisi jika Pembelian)</label>
                        <select name="supplier_id" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Nama Pemesan (Hanya tampil saat Penjualan) -->
                    <div id="user-group" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemesan / Customer (Wajib diisi jika Penjualan)</label>
                        <select name="user_id" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                            <option value="">-- Pilih Pemesan --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Qty)</label>
                            <input type="number" name="quantity" required min="1" value="{{ old('quantity', 1) }}" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Harga Transaksi (Rp)</label>
                            <input type="number" name="total_price" required min="0" step="any" value="{{ old('total_price') }}" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('transactions.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-xl text-sm transition">Batal</a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm shadow transition">Simpan Transaksi & Update Stok</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function toggleTransactionFields() {
            var type = document.getElementById('type').value;
            var supplierGroup = document.getElementById('supplier-group');
            var userGroup = document.getElementById('user-group');

            if (type === 'sale') {
                supplierGroup.style.display = 'none';
                userGroup.style.display = 'block';
            } else {
                supplierGroup.style.display = 'block';
                userGroup.style.display = 'none';
            }
        }

        // Jalankan fungsi saat halaman pertama kali dimuat (berguna jika ada old value / error validasi)
        document.addEventListener('DOMContentLoaded', function() {
            toggleTransactionFields();
        });
    </script>
</x-app-layout>