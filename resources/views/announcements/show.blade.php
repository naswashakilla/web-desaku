<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} - Desa Sejahtera</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg">D</div>
            <div>
                <p class="font-bold text-green-800 leading-tight">Desa Sejahtera</p>
                <p class="text-xs text-gray-400">Portal Informasi Warga</p>
            </div>
        </a>
        <div class="flex gap-4 text-sm items-center">
            <a href="/" class="text-gray-600 hover:text-green-700">Beranda</a>
            <a href="/pengumuman" class="text-gray-600 hover:text-green-700">Pengumuman</a>
            @auth
                <a href="/dashboard" class="text-gray-600 hover:text-green-700">Dashboard</a>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button class="text-red-500 text-sm hover:underline">Logout</button>
                </form>
            @else
                <a href="/login" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Login</a>
            @endauth
        </div>
    </div>
</nav>

<div class="max-w-3xl mx-auto py-8 px-4">

    <a href="/pengumuman" class="text-sm text-gray-400 hover:text-green-600 mb-6 inline-flex items-center gap-1">
        ← Kembali ke Pengumuman
    </a>

    <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-3">

        @if($announcement->image)
            <img src="{{ Storage::url($announcement->image) }}" class="w-full h-72 object-cover">
        @else
            <div class="w-full h-48 bg-gradient-to-br from-green-500 to-green-800 flex items-center justify-center text-6xl">📢</div>
        @endif

        <div class="p-8">
            <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">
                {{ ucfirst($announcement->category) }}
            </span>

            <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-3 leading-tight">
                {{ $announcement->title }}
            </h1>

            <div class="flex flex-wrap gap-4 text-sm text-gray-400 pb-6 mb-6 border-b">
                <span>✍️ {{ $announcement->author->name ?? 'Admin' }}</span>
                <span>📅 {{ $announcement->created_at->format('d M Y') }}</span>
                <span>🕒 {{ $announcement->created_at->format('H:i') }} WIB</span>
                <span>{{ $announcement->created_at->diffForHumans() }}</span>
            </div>

            <div class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                {{ $announcement->content }}
            </div>

            @auth
                <div class="flex gap-3 mt-8 pt-6 border-t">
                    <a href="{{ route('announcements.edit', $announcement) }}"
                       class="bg-yellow-500 text-white px-5 py-2 rounded-lg text-sm hover:bg-yellow-600 transition">
                        ✏️ Edit
                    </a>
                    <form method="POST" action="{{ route('announcements.destroy', $announcement) }}"
                          onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-500 text-white px-5 py-2 rounded-lg text-sm hover:bg-red-600 transition">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </article>

    {{-- Pengumuman Lainnya --}}
    @php
        $others = \App\Models\Announcement::published()
            ->where('id', '!=', $announcement->id)
            ->latest()->take(3)->get();
    @endphp

    @if($others->count() > 0)
        <div class="mt-10">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Pengumuman Lainnya</h2>
            <div class="grid gap-4">
                @foreach($others as $item)
                    <a href="{{ route('announcements.show', $item) }}"
                       class="bg-white rounded-xl border p-4 flex gap-4 hover:shadow-md transition">
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" class="w-20 h-16 object-cover rounded-lg flex-shrink-0">
                        @else
                            <div class="w-20 h-16 bg-gradient-to-br from-green-400 to-green-700 rounded-lg flex items-center justify-center text-xl flex-shrink-0">📢</div>
                        @endif
                        <div>
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">{{ ucfirst($item->category) }}</span>
                            <h3 class="font-semibold text-gray-800 text-sm mt-1">{{ $item->title }}</h3>
                            <p class="text-xs text-gray-400 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

<footer class="bg-green-900 text-green-200 py-6 text-center text-sm mt-12">
    <p>© {{ date('Y') }} Desa Sejahtera · Semua hak dilindungi</p>
</footer>

</body>
</html>