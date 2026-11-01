<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk Sembako') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl relative shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Daftar Katalog Produk Sembako</h3>
                        <p class="text-xs text-gray-500">Kelola inventori, harga, dan stok barang dagangan.</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded-xl text-xs transition">
                            ← Kembali ke Dashboard
                        </a>
                        <a href="{{ route('products.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded-xl text-xs shadow transition">
                            + Tambah Produk Baru
                        </a>
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
                                <th class="py-3 px-4 text-center">Stok</th>
                                <th class="py-3 px-4 text-left">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($products as $index => $prod)
                                <tr class="hover:bg-emerald-50/50 transition">
                                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-mono text-gray-500">{{ $prod->sku }}</td>
                                    <td class="py-3 px-4 font-semibold text-gray-800">{{ $prod->name }}</td>
                                    <td class="py-3 px-4">
                                        <span class="bg-emerald-50 text-emerald-700 text-xs font-medium px-2.5 py-1 rounded-md">
                                            {{ $prod->category->name ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center font-bold text-emerald-600">{{ $prod->stock }} pcs</td>
                                    <td class="py-3 px-4 font-extrabold text-gray-900">Rp {{ number_format($prod->selling_price ?? $prod->price ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10 text-gray-400 italic">Belum ada produk yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>