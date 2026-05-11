<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

{{-- Navbar --}}
<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <span class="font-bold text-lg text-green-700">🏡 Website Desa</span>
    <div class="flex gap-4 text-sm">
        <a href="/" class="text-gray-600 hover:text-green-700">Beranda</a>
        <a href="/pengumuman" class="text-green-700 font-semibold">Pengumuman</a>
        @auth
            <a href="/admin/pengumuman/buat" class="text-blue-600 hover:underline">+ Buat</a>
            <form method="POST" action="/logout" class="inline">
                @csrf
                <button type="submit" class="text-red-500 hover:underline">Logout</button>
            </form>
        @else
            <a href="/login" class="text-gray-600 hover:underline">Login</a>
        @endauth
    </div>
</nav>

{{-- Konten --}}
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">Pengumuman Desa</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse($announcements as $item)
            <div class="bg-white border rounded-lg p-5 shadow-sm">

                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}"
                         class="w-full h-48 object-cover rounded mb-3">
                @endif

                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                    {{ $item->category }}
                </span>

                <h2 class="text-lg font-semibold mt-2">{{ $item->title }}</h2>

                <p class="text-gray-500 text-sm mt-1">
                    Oleh {{ $item->author->name ?? 'Admin' }} ·
                    {{ $item->created_at->diffForHumans() }}
                </p>

                <p class="text-gray-700 mt-2">
                    {{ Str::limit($item->content, 150) }}
                </p>

                <a href="{{ route('announcements.show', $item) }}"
                   class="text-blue-600 text-sm mt-3 inline-block hover:underline">
                    Baca selengkapnya →
                </a>

                @auth
                    <div class="flex gap-3 mt-3 pt-3 border-t">
                        <a href="{{ route('announcements.edit', $item) }}"
                           class="text-sm text-yellow-600 hover:underline">Edit</a>
                        <form method="POST"
                              action="{{ route('announcements.destroy', $item) }}"
                              onsubmit="return confirm('Yakin hapus pengumuman ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-sm text-red-500 hover:underline">Hapus</button>
                        </form>
                    </div>
                @endauth

            </div>
        @empty
            <div class="bg-white rounded-lg p-8 text-center text-gray-400 border">
                <p class="text-lg">Belum ada pengumuman.</p>
                <p class="text-sm mt-1">Silakan login untuk membuat pengumuman pertama.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $announcements->links() }}
    </div>
</div>

</body>
</html>