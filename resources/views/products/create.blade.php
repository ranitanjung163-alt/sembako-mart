<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Sembako Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-6 border border-emerald-100">
                
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Form Tambah Produk</h3>
                        <p class="text-xs text-gray-500">Masukkan detail produk sembako baru ke dalam sistem inventori.</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-medium px-4 py-2 rounded-xl transition">
                        &larr; Kembali
                    </a>
                </div>

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-xs">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kode SKU -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Kode SKU / Barcode</label>
                            <input type="text" name="sku" value="{{ old('sku') }}" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: SKU-BRG-001">
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori Produk</label>
                            <select name="category_id" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Produk Sembako</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: Beras Sania 5kg">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Harga Jual -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Harga Jual (Rp)</label>
                            <input type="number" name="selling_price" value="{{ old('selling_price') }}" min="0" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: 65000">
                        </div>

                        <!-- Stok Awal -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Stok Awal</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: 50">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi Produk (Opsional)</label>
                        <textarea name="description" rows="3" class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Keterangan atau detail produk...">{{ old('description') }}</textarea>
                    </div>

                    <!-- Upload Foto Produk -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Foto Produk</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-150 transition">
                        <p class="text-[10px] text-gray-400 mt-1">Format: JPG, JPEG, PNG, WEBP (Maks. 2MB)</p>
                    </div>

                    <div class="flex justify-end gap-2 pt-4 border-t">
                        <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-semibold px-5 py-2.5 rounded-xl transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-6 py-2.5 rounded-xl shadow transition">
                            Simpan Produk Baru
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>