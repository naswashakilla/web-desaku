<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - Desa Sejahtera</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">D</div>
            <div>
                <p class="font-bold text-green-800 leading-tight">Desa Sejahtera</p>
                <p class="text-xs text-gray-400">Portal Informasi Warga</p>
            </div>
        </a>
        <a href="/laporan" class="text-sm text-gray-600 hover:text-green-700">← Kembali</a>
    </div>
</nav>

<div class="max-w-2xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Buat Laporan Masalah</h1>
    <p class="text-gray-500 text-sm mb-6">Isi form di bawah untuk melaporkan masalah di lingkunganmu</p>

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl mb-6 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl border shadow-sm p-6">
        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Judul --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Judul Laporan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}"
                       placeholder="Contoh: Jalan berlubang di depan RT 03"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            {{-- Kategori --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select name="category" id="category-select"
                        onchange="toggleCustomCategory(this.value)"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Jalan Rusak" {{ old('category') == 'Jalan Rusak' ? 'selected' : '' }}>🛣️ Jalan Rusak</option>
                    <option value="Sampah" {{ old('category') == 'Sampah' ? 'selected' : '' }}>🗑️ Sampah</option>
                    <option value="Banjir" {{ old('category') == 'Banjir' ? 'selected' : '' }}>🌊 Banjir</option>
                    <option value="Penerangan" {{ old('category') == 'Penerangan' ? 'selected' : '' }}>💡 Penerangan</option>
                    <option value="Keamanan" {{ old('category') == 'Keamanan' ? 'selected' : '' }}>🔒 Keamanan</option>
                    <option value="Fasilitas Umum" {{ old('category') == 'Fasilitas Umum' ? 'selected' : '' }}>🏢 Fasilitas Umum</option>
                    <option value="lainnya">✏️ Lainnya (isi sendiri)</option>
                </select>
                <input type="text" name="category" id="custom-category"
                       value="{{ old('category') }}"
                       placeholder="Tulis kategori masalah..."
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm mt-2 focus:outline-none focus:ring-2 focus:ring-green-500 hidden">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Deskripsi Masalah <span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="5"
                          placeholder="Jelaskan masalah secara detail..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description') }}</textarea>
            </div>

            {{-- Lokasi --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Lokasi Kejadian <span class="text-red-500">*</span>
                </label>
                <input type="text" name="location" value="{{ old('location') }}"
                       placeholder="Contoh: Jl. Mawar No. 5, RT 03"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            {{-- Foto --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Masalah (opsional)</label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-400 mt-1">Maks 2MB. Format JPG/PNG</p>
            </div>

            <hr class="my-5">

            <p class="text-sm font-medium text-gray-700 mb-3">Data Pelapor</p>

            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="reporter_name" value="{{ old('reporter_name') }}"
                           placeholder="Nama kamu"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                    <input type="text" name="reporter_phone" value="{{ old('reporter_phone') }}"
                           placeholder="Contoh: 08123456789"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-green-700 transition">
                    📤 Kirim Laporan
                </button>
                <a href="/laporan"
                   class="border border-gray-300 text-gray-600 px-6 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<footer class="bg-green-900 text-green-200 py-6 text-center text-sm mt-12">
    <p>© {{ date('Y') }} Desa Sejahtera</p>
</footer>

<script>
function toggleCustomCategory(value) {
    const select = document.getElementById('category-select');
    const custom = document.getElementById('custom-category');
    if (value === 'lainnya') {
        custom.classList.remove('hidden');
        custom.setAttribute('name', 'category');
        select.removeAttribute('name');
    } else {
        custom.classList.add('hidden');
        custom.removeAttribute('name');
        select.setAttribute('name', 'category');
    }
}
</script>
</body>
</html>