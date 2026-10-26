<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar & Riwayat Pemesanan Sembako') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Tombol Kembali ke Dashboard -->
            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-xl text-sm transition inline-flex items-center gap-2">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tabel Daftar Pesanan -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4">📦 {{ auth()->user()->role === 'user' ? 'Riwayat Pesanan Saya' : 'Daftar Pesanan Masuk' }}</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="py-3 px-4 text-left">No Invoice</th>
                                <th class="py-3 px-4 text-left">Nama Pemesan</th>
                                <th class="py-3 px-4 text-left">No. HP</th>
                                <th class="py-3 px-4 text-left">Detail Produk</th>
                                <th class="py-3 px-4 text-left">Total Harga</th>
                                <th class="py-3 px-4 text-left">Alamat Pengiriman</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                @if(auth()->user()->role !== 'user')
                                    <th class="py-3 px-4 text-left">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 font-mono font-bold text-emerald-600">{{ $order->invoice_number }}</td>
                                    <!-- Kolom Nama Pemesan kini selalu tampil untuk semua role -->
                                    <td class="py-3 px-4 font-semibold text-gray-800">{{ $order->customer_name ?? '-' }}</td>
                                    <td class="py-3 px-4 font-mono text-gray-600">{{ $order->phone ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        @foreach($order->items as $item)
                                            <div>{{ $item->product->name ?? 'Produk' }} (<strong>x{{ $item->quantity }}</strong>)</div>
                                        @endforeach
                                    </td>
                                    <td class="py-3 px-4 font-extrabold text-emerald-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-xs text-gray-500">{{ $order->shipping_address }}</td>
                                    <td class="py-3 px-4">
                                        @php
                                            $statusColors = [
                                                'pending'    => 'bg-amber-100 text-amber-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'completed'  => 'bg-emerald-100 text-emerald-800',
                                                'cancelled'  => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-md text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    @if(auth()->user()->role !== 'user')
                                        <td class="py-3 px-4">
                                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="text-xs rounded-lg border-gray-300 focus:ring-emerald-500 focus:border-emerald-500">
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs px-3 py-1.5 rounded-lg shadow">Ubah</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role !== 'user' ? '8' : '7' }}" class="text-center py-6 text-gray-400 italic">Belum ada riwayat pemesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>