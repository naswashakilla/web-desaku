<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengumuman - Website Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <span class="font-bold text-lg text-green-700">🏡 Website Desa</span>
    <div class="flex gap-4 text-sm items-center">
        <a href="/" class="text-gray-600 hover:text-green-700">Beranda</a>
        <a href="/pengumuman" class="text-gray-600 hover:text-green-700">Pengumuman</a>
        <a href="/dashboard" class="text-gray-600 hover:text-green-700">Dashboard</a>
        <form method="POST" action="/logout" class="inline">
            @csrf
            <button type="submit" class="text-red-500 hover:underline">Logout</button>
        </form>
    </div>
</nav>

<div class="max-w-2xl mx-auto py-8 px-4">

    <div class="flex items-center gap-3 mb-6">
        <a href="/pengumuman" class="text-gray-400 hover:text-gray-600 text-sm">← Kembali</a>
        <h1 class="text-2xl font-bold">Edit Pengumuman</h1>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border rounded-lg p-6">
        <form action="{{ route('announcements.update', $announcement) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Judul Pengumuman <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="title"
                       value="{{ old('title', $announcement->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            {{-- Kategori --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select name="category"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    @foreach(['umum', 'kesehatan', 'keamanan', 'kegiatan', 'infrastruktur'] as $cat)
                        <option value="{{ $cat }}"
                            {{ old('category', $announcement->category) == $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Isi Pengumuman --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Isi Pengumuman <span class="text-red-500">*</span>
                </label>
                <textarea name="content"
                          rows="7"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('content', $announcement->content) }}</textarea>
            </div>

            {{-- Foto --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Foto (opsional)
                </label>
                @if($announcement->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($announcement->image) }}"
                             class="h-32 rounded-lg object-cover">
                        <p class="text-xs text-gray-400 mt-1">Foto saat ini — upload baru untuk mengganti</p>
                    </div>
                @endif
                <input type="file"
                       name="image"
                       accept="image/*"
                       class="w-full text-sm text-gray-500 border border-gray-300 rounded-lg px-3 py-2">
                <p class="text-xs text-gray-400 mt-1">Maksimal 2MB. Format: JPG, PNG</p>
            </div>

            {{-- Publish --}}
            <div class="mb-6 flex items-center gap-2">
                <input type="checkbox"
                       name="is_published"
                       id="is_published"
                       value="1"
                       {{ old('is_published', $announcement->is_published) ? 'checked' : '' }}
                       class="w-4 h-4 text-green-600">
                <label for="is_published" class="text-sm text-gray-700">
                    Publikasi ke warga
                </label>
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3">
                <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-green-700 transition">
                    Simpan Perubahan
                </button>
                <a href="/pengumuman"
                   class="border border-gray-300 text-gray-600 px-6 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

</body>
</html>