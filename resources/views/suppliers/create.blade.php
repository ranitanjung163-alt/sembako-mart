<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Supplier Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-emerald-100 p-8">
                
                <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Supplier</label>
                        <input type="text" name="name" required class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: PT Sembako Jaya Utama">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                        <input type="text" name="phone" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Contoh: 081234567890">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Supplier</label>
                        <textarea name="address" rows="3" class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Alamat lengkap supplier..."></textarea>
                    </div>

                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('suppliers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-xl text-sm transition">Batal</a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-6 py-2.5 rounded-xl text-sm shadow transition">Simpan Supplier</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>