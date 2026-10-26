<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Struk Penjualan: ') . $sale->invoice_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-8 space-y-6">
                
                <!-- Informasi Transaksi -->
                <div class="flex justify-between items-start border-b border-gray-100 pb-6">
                    <div>
                        <span class="text-xs uppercase tracking-wider text-gray-400 font-semibold block">No. Invoice</span>
                        <h3 class="text-lg font-bold text-emerald-600">{{ $sale->invoice_number }}</h3>
                    </div>
                    <div class="text-right">
                        <span class="text-xs uppercase tracking-wider text-gray-400 font-semibold block">Tanggal Transaksi</span>
                        <p class="text-sm font-medium text-gray-700">{{ $sale->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl text-sm">
                    <div>
                        <span class="text-gray-500 block">Kasir / Staff:</span>
                        <span class="font-semibold text-gray-800">{{ $sale->user->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Status Pembayaran:</span>
                        <span class="font-semibold text-emerald-600">Lunas</span>
                    </div>
                </div>

                <!-- Daftar Item Barang -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Daftar Barang Belanjaan</h4>
                    <div class="overflow-x-auto border border-gray-200 rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($sale->items as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-800">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                                        <td class="px-4 py-3 text-sm text-center text-gray-600">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-sm text-right text-gray-600">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-sm text-right font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Rincian Pembayaran -->
                <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between font-bold text-base text-gray-900">
                        <span>Total Belanja:</span>
                        <span>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Uang Dibayar:</span>
                        <span>Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-emerald-600 font-semibold">
                        <span>Uang Kembalian:</span>
                        <span>Rp {{ number_format($sale->change_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('sales.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-xl text-sm transition">Kembali ke Riwayat</a>
                    <button onclick="window.print()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm shadow transition">Cetak Struk</button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>