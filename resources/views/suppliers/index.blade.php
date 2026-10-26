<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-truck-field text-emerald-600"></i> {{ __('Manajemen Supplier Sembako') }}
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

                    <a href="{{ route('suppliers.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-xl text-sm shadow transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Supplier Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-emerald-50 text-emerald-800 text-xs uppercase tracking-wider">
                                <th class="p-3.5 rounded-l-xl">No</th>
                                <th class="p-3.5">Nama Supplier</th>
                                <th class="p-3.5">No. Telepon</th>
                                <th class="p-3.5">Alamat</th>
                                <th class="p-3.5 rounded-r-xl text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse ($suppliers as $index => $supplier)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3.5 font-medium">{{ $index + 1 }}</td>
                                    <td class="p-3.5 font-semibold text-gray-900">{{ $supplier->name }}</td>
                                    <td class="p-3.5">{{ $supplier->phone ?? '-' }}</td>
                                    <td class="p-3.5">{{ $supplier->address ?? '-' }}</td>
                                    <td class="p-3.5 text-center flex justify-center gap-2">
                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">Edit</a>
                                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-gray-400">Belum ada data supplier yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>