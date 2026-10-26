<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-receipt text-emerald-600"></i> {{ __('Riwayat Transaksi (Pembelian & Penjualan)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2.5 rounded-xl text-sm transition flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
                    </a>

                    <a href="{{ route('transactions.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-xl text-sm shadow transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Catat Transaksi Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-emerald-50 text-emerald-800 text-xs uppercase tracking-wider">
                                <th class="p-3.5 rounded-l-xl">No</th>
                                <th class="p-3.5">Jenis</th>
                                <th class="p-3.5">Nama Produk</th>
                                <th class="p-3.5">Supplier</th>
                                <th class="p-3.5">Nama Pemesan</th>
                                <th class="p-3.5">Jumlah</th>
                                <th class="p-3.5">Total Harga (Rp)</th>
                                <th class="p-3.5 rounded-r-xl">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse ($transactions as $index => $trx)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3.5 font-medium">{{ $index + 1 }}</td>
                                    <td class="p-3.5">
                                        @if($trx->type === 'purchase')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded-lg">Barang Masuk (Beli)</span>
                                        @else
                                            <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2.5 py-1 rounded-lg">Barang Keluar (Jual)</span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 font-semibold text-gray-900">{{ $trx->product->name ?? 'Produk Dihapus' }}</td>
                                    <td class="p-3.5">{{ $trx->supplier->name ?? '-' }}</td>
                                    <td class="p-3.5 font-medium text-gray-900">{{ $trx->user->name ?? '-' }}</td>
                                    <td class="p-3.5 font-bold">{{ $trx->quantity }} pcs</td>
                                    <td class="p-3.5 font-medium text-emerald-600">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                                    <td class="p-3.5 text-xs text-gray-500">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-8 text-gray-400">Belum ada riwayat transaksi tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>