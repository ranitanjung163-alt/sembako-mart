<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Transaksi Barang Masuk (Restock)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Daftar Barang Masuk dari Supplier</h3>
                        <p class="text-xs text-gray-500">Rekapitulasi stok masuk dan penambahan inventori secara real-time.</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('purchases.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl text-xs shadow transition">
                            + Input Barang Masuk Baru
                        </a>
                        <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded-xl text-xs transition">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="py-3 px-4 text-left">No</th>
                                <th class="py-3 px-4 text-left">Nama Barang</th>
                                <th class="py-3 px-4 text-left">Nama Supplier</th>
                                <th class="py-3 px-4 text-center">Jumlah Stok Masuk</th>
                                <th class="py-3 px-4 text-center">Total Stok Terkini</th>
                                <th class="py-3 px-4 text-left">Tanggal & Jam Masuk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($purchases as $index => $purchase)
                                @foreach($purchase->purchaseItems as $item)
                                    <tr class="hover:bg-emerald-50/50 transition">
                                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4 font-semibold text-gray-800">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                                        <td class="py-3 px-4 text-gray-600">{{ $purchase->supplier->name ?? 'Supplier Dihapus' }}</td>
                                        <td class="py-3 px-4 text-center font-bold text-emerald-600">+{{ $item->quantity }} pcs</td>
                                        <td class="py-3 px-4 text-center font-bold text-blue-600">{{ $item->product->stock ?? 0 }} pcs</td>
                                        <td class="py-3 px-4 text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-m-Y') }} 
                                            <span class="text-gray-400">({{ $purchase->created_at->format('H:i:s') }})</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-gray-400 italic">Belum ada data transaksi barang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>