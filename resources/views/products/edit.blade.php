<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk Sembako') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-8">
                
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Input Kode SKU -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode SKU Unik <span class="text-red-500">*</span></label>
                        <input type="text" name="sku" required value="{{ old('sku', $product->sku) }}" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                        @error('sku')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk Sembako <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required value="{{ old('name', $product->name) }}" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Jual & Jumlah Stok (Grid 2 Kolom) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga Produk (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="selling_price" required min="0" step="0.01" value="{{ old('selling_price', $product->selling_price ?? $product->price ?? 0) }}" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: 15000">
                            @error('selling_price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" required min="0" value="{{ old('stock', $product->stock) }}" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                            @error('stock')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Ganti / Upload Foto Produk -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Produk (Opsional)</label>
                        @if($product->image)
                            <div class="mb-3">
                                <span class="text-xs text-gray-500 block mb-1">Foto Saat Ini:</span>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded-xl shadow">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto.</p>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Produk -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk (Opsional)</label>
                        <textarea name="description" rows="3" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-xl text-sm transition">Kembali</a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm shadow transition">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>