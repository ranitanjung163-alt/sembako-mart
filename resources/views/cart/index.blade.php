<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-xl text-sm transition">
                    &larr; Kembali ke Dashboard
                </a>
                <a href="{{ route('orders.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-xl text-sm shadow transition">
                    Lihat Riwayat Pemesanan Saya
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-6 space-y-6">
                
                @if(session('success'))
                    <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl relative">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kuantitas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $grandTotal = 0; @endphp
                            @forelse($carts as $cart)
                                @php
                                    $price = $cart->product->selling_price ?? $cart->product->price ?? $cart->product->harga ?? $cart->product->harga_jual ?? 10000;
                                    $subtotal = $price * $cart->quantity;
                                    $grandTotal += $subtotal;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">{{ $cart->product->name ?? 'Produk' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Rp {{ number_format($price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-emerald-600">{{ $cart->quantity }} pcs</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded-lg border border-red-200 transition text-xs">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400 italic">Keranjang belanja Anda masih kosong.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($carts->isNotEmpty())
                    <!-- FORM INPUT NAMA PEMESAN, NOMOR HP & ALAMAT SEBELUM CHECKOUT -->
                    <form action="{{ route('cart.checkout') }}" method="POST" class="bg-emerald-50/60 border border-emerald-200 p-5 rounded-2xl space-y-4">
                        @csrf
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">📋 Informasi Pengiriman Pesanan</h4>
                            <p class="text-xs text-amber-700 font-medium">⚠️ Perhatian: Mohon isi <b>Nama Lengkap Pemesan</b>, <b>Nomor HP</b>, dan <b>Alamat Pengiriman</b> dengan lengkap terlebih dahulu agar pesanan dapat disimpan ke dalam Riwayat Pemesanan.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap Pemesan</label>
                                <input type="text" name="customer_name" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: Rani Rahmayanti">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                                <input type="text" name="phone" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: 081234567890">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Lengkap Pengiriman</label>
                                <input type="text" name="shipping_address" required class="w-full text-xs rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: Jl. Merdeka No. 10">
                            </div>
                        </div>

                        <div class="border-t pt-4 flex justify-between items-center">
                            <div>
                                <span class="text-gray-600 text-sm">Total Keseluruhan Belanja:</span>
                                <h3 class="text-2xl font-extrabold text-emerald-700">Rp {{ number_format($grandTotal, 0, ',', '.') }}</h3>
                            </div>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg transition text-sm">
                                Pesan Sekarang & Simpan ke Riwayat
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>