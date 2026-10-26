<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori - Sembako Mart</title>
    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-emerald-50 to-teal-100 min-h-screen font-sans antialiased text-gray-800">

    <!-- Navbar Sederhana -->
    <nav class="bg-emerald-700 text-white shadow-md py-4 px-6 mb-8">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-store text-2xl"></i>
                <span class="text-xl font-bold tracking-wide">Sembako Mart Dashboard</span>
            </div>
            <a href="/" class="text-sm bg-emerald-800 hover:bg-emerald-900 px-3 py-1.5 rounded-lg transition"><i class="fa-solid fa-house mr-1"></i> Beranda</a>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="max-w-5xl mx-auto px-4">
        
        <!-- Notifikasi Sukses jika ada -->
        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100 p-8">
            
            <!-- Header Judul & Tombol Tambah -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                <div>
                    <h1 class="text-2xl font-extrabold text-emerald-900 flex items-center gap-2">
                        <i class="fa-solid fa-tags text-emerald-600"></i> Daftar Kategori Produk
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola kategori barang dagangan Sembako Mart dengan mudah dan cepat.</p>
                </div>
                <a href="/categories/create" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-600/20 transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Kategori
                </a>
            </div>

            <!-- Tabel Data -->
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-emerald-50 text-emerald-900 text-sm uppercase tracking-wider">
                            <th class="py-3.5 px-6 font-semibold text-center w-16">No</th>
                            <th class="py-3.5 px-6 font-semibold">Nama Kategori</th>
                            <th class="py-3.5 px-6 font-semibold text-center w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($categories as $index => $category)
                        <tr class="hover:bg-emerald-50/50 transition">
                            <td class="py-4 px-6 text-center font-medium text-gray-600">{{ $categories->firstItem() + $index }}</td>
                            <td class="py-4 px-6 font-semibold text-gray-800">{{ $category->name }}</td>
                            <td class="py-4 px-6 text-center space-x-2">
                                <!-- Tombol Edit -->
                                <a href="/categories/{{ $category->id }}/edit" class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg font-medium transition">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <!-- Tombol Hapus -->
                                <form action="/categories/{{ $category->id }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg font-medium transition">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-gray-400 bg-gray-50/50">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <i class="fa-solid fa-box-open text-4xl text-emerald-300"></i>
                                    <p class="text-base font-medium">Belum ada data kategori yang tersimpan.</p>
                                    <span class="text-xs text-gray-400">Silakan klik tombol "Tambah Kategori" di atas untuk mulai memasukkan data.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Navigasi Pagination -->
            <div class="mt-6">
                {{ $categories->links() }}
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-6 text-xs text-emerald-800/60 mt-12">
        Sembako Mart Inventory System &copy; 2026 &bull; Dibuat dengan penuh semangat untuk UTS Pemrograman Web
    </footer>

</body>
</html>