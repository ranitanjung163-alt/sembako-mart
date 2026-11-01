<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kasir / Transaksi Penjualan Sembako') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-8">
                
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('sales.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Pilih Produk & Kuantitas (Multi-Item) -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-gray-700">Daftar Produk Belanjaan <span class="text-red-500">*</span></label>
                            <button type="button" onclick="addProductRow()" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-1.5 rounded-xl shadow transition">
                                + Tambah Produk Lain
                            </button>
                        </div>
                        
                        <div id="product-list" class="space-y-3">
                            <div class="border border-gray-200 rounded-xl p-4 bg-gray-50 product-row">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                    <div class="md:col-span-8">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Produk</label>
                                        <select name="items[0][product_id]" required class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm text-sm">
                                            <option value="" disabled selected>-- Pilih Produk (Stok Tersedia) --</option>
                                            @foreach($products as $product)
                                                @php
                                                    $pPrice = $product->selling_price ?? $product->price ?? $product->harga ?? $product->harga_jual ?? 0;
                                                @endphp
                                                <option value="{{ $product->id }}">
                                                    {{ $product->name }} (Stok: {{ $product->stock }} | Rp {{ number_format($pPrice, 0, ',', '.') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="md:col-span-3">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Kuantitas (Qty)</label>
                                        <input type="number" name="items[0][quantity]" required min="1" value="1" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm text-sm" placeholder="Jumlah">
                                    </div>

                                    <div class="md:col-span-1 flex items-end">
                                        <button type="button" onclick="removeRow(this)" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-xl text-xs transition mt-5 md:mt-0">X</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('items')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Pembayaran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Uang Dibayar (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="paid_amount" required min="0" step="0.01" value="{{ old('paid_amount') }}" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: 100000">
                        @error('paid_amount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('sales.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-xl text-sm transition">Kembali</a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm shadow transition">Proses Transaksi</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script JavaScript untuk Multi-Item Dinamis -->
    <script>
        let rowIndex = 1;

        function addProductRow() {
            let list = document.getElementById('product-list');
            let row = document.createElement('div');
            row.className = 'border border-gray-200 rounded-xl p-4 bg-gray-50 product-row';
            row.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <div class="md:col-span-8">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Produk</label>
                        <select name="items[${rowIndex}][product_id]" required class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm text-sm">
                            <option value="" disabled selected>-- Pilih Produk (Stok Tersedia) --</option>
                            @foreach($products as $product)
                                @php
                                    $pPrice = $product->selling_price ?? $product->price ?? $product->harga ?? $product->harga_jual ?? 0;
                                @endphp
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} (Stok: {{ $product->stock }} | Rp {{ number_format($pPrice, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Kuantitas (Qty)</label>
                        <input type="number" name="items[${rowIndex}][quantity]" required min="1" value="1" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm text-sm" placeholder="Jumlah">
                    </div>

                    <div class="md:col-span-1 flex items-end">
                        <button type="button" onclick="removeRow(this)" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-xl text-xs transition mt-5 md:mt-0">X</button>
                    </div>
                </div>
            `;
            list.appendChild(row);
            rowIndex++;
        }

        function removeRow(button) {
            let rows = document.getElementsByClassName('product-row');
            if (rows.length > 1) {
                button.closest('.product-row').remove();
            } else {
                alert('Minimal harus ada 1 produk dalam transaksi!');
            }
        }
    </script>
</x-app-layout>