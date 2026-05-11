<x-app-layout>
    <div class="max-w-2xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Buat Pengumuman</h1>

        <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white border rounded-lg p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border rounded px-3 py-2" required>
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded px-3 py-2">
                    <option value="umum">Umum</option>
                    <option value="kesehatan">Kesehatan</option>
                    <option value="keamanan">Keamanan</option>
                    <option value="kegiatan">Kegiatan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Isi Pengumuman</label>
                <textarea name="content" rows="6"
                          class="w-full border rounded px-3 py-2" required>{{ old('content') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Foto (opsional)</label>
                <input type="file" name="image" accept="image/*" class="w-full">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="is_published" value="1" checked>
                <label for="is_published" class="text-sm">Langsung publikasi</label>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
                Simpan Pengumuman
            </button>
        </form>
    </div>
</x-app-layout>