<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - Sembako Mart</title>
    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-emerald-50 to-teal-100 min-h-screen font-sans antialiased text-gray-800 flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100 p-8">
        
        <!-- Header Form -->
        <div class="mb-6 pb-4 border-b border-gray-100 flex items-center justify-between">
            <h1 class="text-xl font-extrabold text-emerald-900 flex items-center gap-2">
                <i class="fa-solid fa-folder-plus text-emerald-600"></i> Tambah Kategori Baru
            </h1>
            <a href="/categories" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </a>
        </div>

        <!-- Pesan Error Validasi jika ada -->
        @if ($errors->any())
            <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Input -->
        <form action="/categories" method="POST">
            @csrf
            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <i class="fa-solid fa-tag"></i>
                    </span>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Sembako, Minuman, dll." required
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition text-sm">
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="/categories" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl text-sm transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl text-sm shadow-lg shadow-emerald-600/20 transition flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Data
                </button>
            </div>
        </form>

    </div>

</body>
</html>