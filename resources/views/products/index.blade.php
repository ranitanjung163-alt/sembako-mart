<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk Sembako') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-xl text-sm transition">&larr; Kembali ke Dashboard</a>
                <a href="{{ route('products.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-5 py-2.5 rounded-xl text-sm shadow transition">+ Tambah Produk Baru</a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="py-3 px-4">No</th>
                                <th class="py-3 px-4">Foto</th>
                                <th class="py-3 px-4">Kode SKU</th>
                                <th class="py-3 px-4">Nama Produk</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4">Harga (Rp)</th>
                                <th class="py-3 px-4">Stok</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($products as $index => $product)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-xl shadow-sm">
                                        @else
                                            <span class="text-xs text-gray-400 italic">Tanpa Foto</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-mono font-medium text-emerald-600">{{ $product->sku }}</td>
                                    <td class="py-3 px-4 font-semibold text-gray-800">{{ $product->name }}</td>
                                    <td class="py-3 px-4">
                                        <span class="bg-emerald-50 text-emerald-700 text-xs font-medium px-2.5 py-1 rounded-md">
                                            {{ $product->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-medium">
                                        @php
                                            $pPrice = $product->selling_price ?? $product->price ?? $product->harga ?? $product->harga_jual ?? 0;
                                        @endphp
                                        Rp {{ number_format($pPrice, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 font-bold text-emerald-600">{{ $product->stock }} pcs</td>
                                    <td class="py-3 px-4 text-center space-x-2">
                                        <a href="{{ route('products.edit', $product->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium shadow transition">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium shadow transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-gray-500 italic">Belum ada data produk sembako.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>