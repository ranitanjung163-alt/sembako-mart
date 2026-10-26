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

                    <!-- Pilih Produk & Kuantitas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Produk Sembako <span class="text-red-500">*</span></label>
                        
                        <div class="border border-gray-200 rounded-xl p-4 bg-gray-50 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                <div class="md:col-span-8">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Produk</label>
                                    <select name="items[0][product_id]" required class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                                        <option value="" disabled {{ old('items.0.product_id') ? '' : 'selected' }}>-- Pilih Produk (Stok Tersedia) --</option>
                                        @foreach($products as $product)
                                            @php
                                                $pPrice = $product->selling_price ?? $product->price ?? $product->harga ?? $product->harga_jual ?? 0;
                                            @endphp
                                            <option value="{{ $product->id }}" {{ old('items.0.product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} (Stok: {{ $product->stock }} | Rp {{ number_format($pPrice, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="md:col-span-4">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Kuantitas (Qty)</label>
                                    <input type="number" name="items[0][quantity]" required min="1" value="{{ old('items.0.quantity', 1) }}" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Jumlah">
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
</x-app-layout>